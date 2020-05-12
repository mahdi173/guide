<?php


namespace App\Controller;



use App\Entity\Allpublications;
use App\Entity\DataReuters;
use App\Entity\DataTScopus;
use App\Entity\Follow;
use App\Form\AllPublicationCreateType;
use App\Form\AllPublicationType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/{_locale}/profile/conference")
 */


class BaseController extends AbstractController
{

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var LoggerInterface */
    private $logger;

    /**
     * BaseController constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger,EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/author_search", name="author_search", methods={"GET"})
     */

    public function author_search(Request $request)
    {
        $emS = $this->getDoctrine()->getManager();
        $exist = $emS->getRepository(Allpublications::class)->findBy(['user' => $this->getUser()]);
        if ($exist && $this->getUser()->getFullName()) {
            return $this->redirectToRoute('publication_index');
        } else {
            $auteur = $this->getUser()->getFirstName();


            $test = false;
            if (strpos($request->getUri(), 'authorValue') !== false) {
                $test = true;
            }
            $param = urlencode($auteur); // str_replace(' ','+',$auteur);
            $data = null;
            try {
                $rawData = HttpClient::create()
                    ->request('GET', "https://dblp.org/search/author/api?q=$param&format=json")
                    ->getContent();
                $data = \json_decode($rawData);
            } catch (TransportExceptionInterface $exception) {
                $this->addFlash('error', 'Ooops ! Something wrong happened. Please retry again or contact the support');
                $this->logger->critical($exception->getTraceAsString());
            }

            return $this->render('authors/author_search.html.twig', [
                'data' => $data
            ]);
        }
    }
    /**
     * @Route("/save_url_social", name="save_url_social")
     */
    public function save_url_social(Request $request)
    {
        $user=$this->getUser();

     $facebook=$request->get('facebook');
     $twitter=$request->get('twitter');
     $linkeid=$request->get('linkedin');

        if($facebook!=""){
            $user->setFacebook($facebook);
        }
        if($twitter!=""){
            $user->setTwitter($twitter);
        }
        if($linkeid!=""){
            $user->setLinkedin($linkeid);
        }
        $em=$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('author_search');
    }


    /**
     * @Route("/allpublications" ,name="get_author_allpublication_profile",options = { "expose" = true })
     *
     */
    public function callAllpubapi(Request $request){

        $auteur = $request->get('auteur');
        $param=str_replace(' ','+',$auteur);
        $data_doaj = null;
        $data_dblp=null;

        // debut

        $auteur = $request->get('auteur');
        $param  = urlencode($auteur); // str_replace(' ','+',$auteur);
        try {
            $rawData = HttpClient::create()
                ->request('GET', "https://doaj.org/api/v1/search/articles/$param")
                ->getContent()
            ;
            $data_doaj = \json_decode($rawData);
        }catch (TransportExceptionInterface $exception){
            $this->addFlash('error', 'Ooops ! Something wrong happened. Please retry again or contact the support');
            $this->logger->critical($exception->getTraceAsString());
        }

        // fin


        // debut
        try {
            $rawData2 = HttpClient::create()
                ->request('GET', "https://dblp.org/search/publ/api?q=.$param.&format=json")
                ->getContent()
            ;
            $data_dblp = \json_decode($rawData2);
        }catch (TransportExceptionInterface $exception){
            $this->addFlash('error', 'Ooops ! Something wrong happened. Please retry again or contact the support');
            $this->logger->critical($exception->getTraceAsString());
        }

        // fin


        $result = $data_dblp->result->hits;
        $result2= $data_doaj->results;

        $inc = false;
        $array = [];
        foreach ($result->hit as $r){
            $inc = false;
            foreach ($result2 as $r2){
                if (rtrim($r->info->title,'. ') == rtrim($r2->bibjson->title,'. ')){
                    $inc = true;
                }
            }
            if($inc == false ){
                $array[] = $r;
            }
        }
        /*debut search issn in scopus or router*/
        //dd($result2);


        $data=[];
        $emS = $this->getDoctrine()->getManager();
        $em = $this->entityManager->getRepository(DataTScopus::class);
        $em22 = $this->entityManager->getRepository(DataTScopus::class)->findAll();
        $em2 = $this->entityManager->getRepository(DataReuters::class);
        $dd1=[];

        if($result2 !=null){
            foreach ($result2 as $issn){
                $issn2=str_replace("-","",$issn->bibjson->journal->issns);

                $res_scopus=$em->findInScopusByIssn($issn2, $emS);
                $res_reuters = $em2->findInThomsonByIssn($issn2, $emS);
                if ($res_scopus==null && $res_reuters!=null){
                    $dd1[]=$res_reuters;
                }elseif($res_scopus!=null && $res_reuters==null){
                    $dd1[]=$res_scopus;
                }elseif ($res_scopus!=null &&  $res_reuters!=null){
                    $dd1[]=$res_scopus;
                }

            }
        }

        $this->getUser()->setFullName($auteur);
            if(!empty($result)){

                foreach ($array as $item){
                    $authors="";
                    $pub=new Allpublications();
                    $pub->setUser($this->getUser());
                    $pub->setTitle($item->info->title);
                    $pub->setName($item->info->venue);
                    if(array_key_exists('volume',$item->info)){
                        $pub->setVolume($item->info->volume);
                    }
                    else{
                        $pub->setVolume(null);
                    }
                    $pub->setYear($item->info->year);
                    $pub->setUrl($item->info->url);
                    $pub->setPages($item->info->pages);

                    foreach ($item->info->authors as $a) {
                        if(!is_array($a)){
                            $authors=$authors.' , '.$a->text;
                            $pub->setAuthors($authors);
                        }
                      else{
                          foreach ($a as $at){
                              $authors=$authors.' , '.$at->text;
                              $pub->setAuthors($authors);
                          }
                      }
                    }
                    $emS->persist($pub);

                }
            }

            if(!empty($result2)){
                foreach ($result2 as $item){

                    $authors="";
                    $pub=new Allpublications();
                    $pub->setUser($this->getUser());
                    $pub->setTitle($item->bibjson->title);
                    if(array_key_exists('volume',$item->bibjson->journal)){
                        $pub->setVolume($item->bibjson->journal->volume);
                    }
                    else{
                        $pub->setVolume(null);
                    }
                    $pub->setYear($item->bibjson->year);
                    foreach ($item->bibjson->link as $link) {
                        $pub->setUrl($link->url);
                    }
//                    $pub->setPages($item->bibjson->pages);

                    foreach ($item->bibjson->author as $a) {
                        if(!is_array($a)){
                            $authors=$authors.' , '.$a->name;
                            $pub->setAuthors($authors);
                        }
                        else{
                            foreach ($a as $at){
                                $authors=$authors.' , '.$at->name;
                                $pub->setAuthors($authors);
                            }
                        }
                    }

                    $emS->persist($pub);
                    $emS->persist($this->getUser());
                }
            }
            $emS->flush();


        /*end*/
return $this->redirectToRoute('publication_index');
//        return $this->render('authors/all_publications_profile.html.twig',['data_doaj'=>$data_doaj,'data_dblp'=>$array,'dataissn'=>$dd1]);
    }

    /**
     * @Route("/all_publication/{id}", name="all_publication_delete", methods={"DELETE"}, requirements={"id":"\d+"})
     */
    public function delete(Request $request, Allpublications $publication): Response
    {

//        if ($this->isCsrfTokenValid('delete'.$publication->getId(), $request->request->get('_token'))) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publication);
            $entityManager->flush();
//        }

        return $this->redirectToRoute('publication_index');
    }

    /**
     * @Route("/add_follower/{author}/{exist}/{redirect}", name="add_follower", methods={"GET"})
     */
    public function add_follower(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $auteur = $request->get('author');
        $exist= $request->get('exist');
        $route= $request->get('redirect');
        if($route=="get_authors_publication"){
            $parameter="auteur";
        }else{
            $parameter="authorValue";
        }
        $user=$this->getUser();
      //  $exist=$entityManager->getRepository(Follow::class)->findBy(['following'=>$auteur]);
        if($exist==0){
            $follow=new Follow();
            $follow->setFollowing($auteur);
            $follow->addFollower($user);

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute($route,[$parameter=>$auteur]);
        }
        else{
            $following=$entityManager->getRepository(Follow::class)->findBy(['following'=>$auteur]);
            $entityManager->remove($following[0]);
            $entityManager->flush();
            return $this->redirectToRoute($route,[$parameter=>$auteur]);
        }
    }
    /**
     * @Route("/followers_index/", name="followers_index", methods={"GET"})
     */
    public function followers_index(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $myFollowers=$entityManager->getRepository(Follow::class)->findAllFollowers($user->getFullName());


        $allPublication=$entityManager->getRepository(Allpublications::class)->findAll();
        $allFollow=$entityManager->getRepository(Follow::class)->findAll();


            return $this->render("follow/followers_index.html.twig",[
                'exist'=>$myFollowers,
                'myFollowers'=>$myFollowers,
                'allPublication'=>$allPublication,
                'allFollow'=>$allFollow,
            ]);


    }

    /**
     * @Route("/following_index/", name="following_index", methods={"GET"})
     */
    public function following_index(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $exist=$entityManager->getRepository(Follow::class)->findAllFollowing($user);

        $allPublication=$entityManager->getRepository(Allpublications::class)->findAll();
        $allFollow=$entityManager->getRepository(Follow::class)->findAll();


        return $this->render("follow/following_index.html.twig",[
            'exist'=>$exist,
            'allPublication'=>$allPublication,
            'allFollow'=>$allFollow,
        ]);


    }



}
