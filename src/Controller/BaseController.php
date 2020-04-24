<?php


namespace App\Controller;



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

    /** @var LoggerInterface */
    private $logger;

    /**
     * BaseController constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
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
}
