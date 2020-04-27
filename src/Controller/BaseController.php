<?php


namespace App\Controller;



use App\Entity\DataReuters;
use App\Entity\DataTScopus;
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

        $auteur = $this->getUser()->getFirstName();


        $test=false;
        if (strpos($request->getUri(), 'authorValue') !== false){
            $test=true;
        }
        $param  = urlencode($auteur); // str_replace(' ','+',$auteur);
        $data = null;
        try {
            $rawData = HttpClient::create()
                ->request('GET', "https://dblp.org/search/author/api?q=$param&format=json")
                ->getContent()
            ;
            $data = \json_decode($rawData);
        }catch (TransportExceptionInterface $exception){
            $this->addFlash('error', 'Ooops ! Something wrong happened. Please retry again or contact the support');
            $this->logger->critical($exception->getTraceAsString());
        }

        return $this->render('authors/author_search.html.twig', [
          'data'=>$data
        ]);
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
dump($request);
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

        /*end*/
        dump($data_doaj,$array,$dd1,$param);
        return $this->render('authors/all_publications_profile.html.twig',['data_doaj'=>$data_doaj,'data_dblp'=>$array,'dataissn'=>$dd1]);
    }
}
