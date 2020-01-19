<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchauthorsController extends AbstractController{


    /**
     * @Route("/authors" ,name="get_authors")
     *
     * find the authors
     */
    public function callapi(Request $request){

//        $client = new \GuzzleHttp\Client([
//            // Base URI is used with relative requests
//            'base_uri' => 'https://dblp.org/search/author/api?format=json',
//        ]);
//
//        try {
//            $response=$client->getAsync('search/author/api',
//                    [
//                        'headers' => [
//                            'Content-Type' => 'text/xml',
//                        ],
//                        'query' => ["q"=>"Tsu",'format'=>'json']
//                    ]
//            )->then( function (\Psr\Http\Message\ResponseInterface $res) {
//
//                        return $res;
//                    },
//                    function (\GuzzleHttp\Exception\RequestException $e) {
//                        dump($e);die;
//                        return null;
//                    }
//                );
//            try {
//                $response = $response->wait();
//                dump($response);die;
//                return $response;
//
//            } catch (\Exception $exception) {
//                dump($exception);die;
//                return null;
//            }
//        }catch(\GuzzleHttp\Exception\ServerException $exception){
//            dump($exception);die;
//            return null;
//        }
//        dump($response);die;


        $auteur = $request->get('authorValue');
        $auteur=htmlspecialchars($auteur);
        $param=str_replace(' ','+',$auteur);
        $data = null;
        if($param!=null)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://dblp.org/search/author/api?q=$param&format=json");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            // If using JSON...
            $data = json_decode($response);

        }

                return $this->render('authors/authors.html.twig',['data'=>$data]);
    }


    /**
     * @Route("/authors/publication" ,name="get_authors_publication")
     *
     * find a publications of author
     */
    public function callpubapi(Request $request){

        $auteur = $request->get('auteur');
        $param=str_replace(' ','+',$auteur);
        $data_doaj = null;
        $data_dblp=null;
        if($param!=null)
        {
            // doaj API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://doaj.org/api/v1/search/articles/$param");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $response = curl_exec($ch);
            // If using JSON...
            $data_doaj = json_decode($response);

        }

        $test='teste teet . yeyte, hello test. ';
        if($param!=null)
        {
            //dblp API
            $ch2 = curl_init();
            curl_setopt($ch2, CURLOPT_URL, "https://dblp.org/search/publ/api?q=.$param.&format=json");
            curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);

            $response2 = curl_exec($ch2);
            $data_dblp= json_decode($response2);
        }
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

        return $this->render('authors/publications.html.twig',['data_doaj'=>$data_doaj,'data_dblp'=>$array]);
    }



}
