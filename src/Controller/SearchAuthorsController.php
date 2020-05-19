<?php

namespace App\Controller;

use App\Entity\DataReuters;
use App\Entity\DataTScopus;
use App\Entity\Follow;
use App\Service\Sortpublication;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class SearchAuthorsController extends AbstractController
{

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var LoggerInterface */
    private $logger;

    /**
     * SearchAuthorsController constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }


    /**
     * @Route("/authors" ,name="get_authors")
     *
     * find the authors
     */
    public function callapi(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $auteur = $request->get('authorValue');
        $countFollowers=0;
        $exist=$entityManager->getRepository(Follow::class)->findBy(['following'=>trim($auteur)]);
        $allFollowers=$entityManager->getRepository(Follow::class)->findAll();

        if($exist){
            $countFollowers=count($exist);
        }
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
        $array_doaj = array();
        $array_dblp = array();
        $total=array();
        if($data && $data->result->query!==""){

        foreach ($data->result->hits->hit as $a)
        {
            // debut
            $aut= $a->info->author;
            $par  = urlencode($aut); // str_replace(' ','+',$auteur);
            $data_doaj = null;

            $data_dblp=null;
            $count_data_dblp=0;
            $count_data_dblp=0;
            try {
                $rawData = HttpClient::create()
                    ->request('GET', "https://doaj.org/api/v1/search/articles/$par")
                    ->getContent()
                ;
                $data_doaj = \json_decode($rawData);
             $az=str_replace('+',' ',$data_doaj->query);
             $az=str_replace('.','',$az);
             $az=str_replace('-',' ',$az);

                if(count($data_doaj->results)>0){
//                    array_push($array_doaj,count($data_doaj->results));
                    $array_doaj[$az]=count($data_doaj->results);
                }else{
//                    array_push($array_doaj,0);
                    $array_doaj[$az]=0;
                }

            }catch (TransportExceptionInterface $exception){
                $this->addFlash('error', 'Ooops ! Something wrong happened. Please retry again or contact the support');
                $this->logger->critical($exception->getTraceAsString());
            }

            // fin

            // debut
            try {
                $rawData2 = HttpClient::create()
                    ->request('GET', "https://dblp.org/search/publ/api?q=.$par.&format=json")
                    ->getContent()
                ;
                $data_dblp = \json_decode($rawData2);

                $res=str_replace('*','',$data_dblp->result->query);

                if(count($data_dblp->result->hits->hit)>0){
//               array_push($array_dblp,count($data_dblp->result->hits->hit));
                    $array_dblp[$res]=count($data_dblp->result->hits->hit);
                }
                else{
//                    array_push($data_dblp,0);
                    $array_dblp[$res]=0;
                }

            }catch (TransportExceptionInterface $exception){
                $this->addFlash('error', 'Ooops ! Something wrong happened. Please retry again or contact the support');
                $this->logger->critical($exception->getTraceAsString());
            }

            // fin

        }

//            dd($array_doaj,$array_dblp);
            foreach ($array_dblp as $key => $value) {
                foreach ($array_doaj as $key1 => $value1){
                    if ($key === $key1) {
                        $total[$key] = $value + $value1;

                    }
                    else{
                      //  dd($key,$key1);
                    }
            }
            }


    }
        return $this->render('authors/authors.html.twig',
            ['data'=> $data,'parametre'=>$test,'exist'=>$exist,'countFollowers'=>$countFollowers,'allFollowers'=>$allFollowers,'array_dblp'=>$array_dblp,'array_doaj'=>$array_doaj,'total'=>$total]);
    }

    /**
     * @Route("/authors/publication" ,name="get_authors_publication")
     *
     * find a publications of author
     */
    public function callpubapi(Request $request){

        $auteur = $request->get('auteur');
        $exist=$this->entityManager->getRepository(Follow::class)->findBy(['following'=>$auteur]);
        $countFollowers=0;
        if($exist){
            $countFollowers=count($exist);
        }
        $param=str_replace(' ','+',$auteur);
        $data_doaj = null;
        $data_dblp=null;

        // debut

        $auteur = $request->get('auteur');
        $param  = urlencode($auteur); // str_replace(' ','+',$auteur);
        try {
            $rawData = HttpClient::create()
                ->request('GET', "https://doaj.org/api/v1/search/articles/$param.?pageSize=100&sort=year:desc")
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
                ->request('GET', "https://dblp.org/search/publ/api?q=.$param.&format=json&h=100")
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

        $datadlp=$this->sortdblp($array,count($array));

        /*end*/

        return $this->render('authors/publications.html.twig',
            ['data_doaj'=>$data_doaj,
                'data_dblp'=>$array,
                'dataissn'=>$dd1,
                'auteur'=> $auteur,
                'exist'=> $exist,
                'countFollowers'=> $countFollowers,
            ]);
    }

    /**
     * sort by date data gived by dblp api
     * @param $a
     * @param $b
     * @return mixed
     */
    public function sortdblp($a,$b){
        $temp=[];
        for($i=0;$i<$b;$i++){
            for ($j=0;$j<$b;$j++){
                if ($a[$i]->info->year > $a[$j]->info->year)
                {
                    $temp=$a[$i];
                    $a[$i]=$a[$j];
                    $a[$j]=$temp;
                }
            }
        }
        return $a;

    }

}
