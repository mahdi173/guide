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


        $param = $request->get('authorValue');
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
        $data = null;
//        dump($param);die();
        if($param!=null)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://dblp.org/search/publ/api?q=.$param.&format=json");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            // If using JSON...
            $data = json_decode($response);
        }
        return $this->render('authors/publications.html.twig',['data'=>$data]);
    }

}
