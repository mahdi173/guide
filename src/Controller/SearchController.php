<?php


namespace App\Controller;


use App\Entity\DataReuters;
use App\Entity\DataScopus;
use App\Entity\DataTScopus;
use App\Entity\Search;
use App\Form\SearchType;
use App\Service\ServiceForJournalFinder;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchController
 *
 * @package App\Controller
 */
class SearchController extends BaseController
{

    private $journalFinder;
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * SearchController constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param PaginatorInterface $paginator
     */
    public function __construct(EntityManagerInterface $entityManager, PaginatorInterface $paginator, ServiceForJournalFinder $srJfinder)
    {

        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
        $this->journalFinder= $srJfinder;

    }


    /**
     *
     * @Route("/query", name="data_search_by_several_values")
     */
    public function searchByValue(Request $request)
    {

        $objet = new Search();
        $data_t_scopus = null;
        $data_reuters = null;
        $pagination_slide=null;
        $topjournallistScopus=null;
        $eISSNSend=null;
        $form = $this->createForm(SearchType::class, $objet);
        //$form->handleRequest($request);


        if ($request->get("searchValue")) {


            // modification par outmane le 11/05/2020 à 10h00
            $val=$request->get("searchValue");
            $array=explode(" ", $val);

            $new_value="";

                for ($i = 0; $i < (count($array)); $i++) {
                    if ($array[$i] != " "){
                        if($i==0){
                        $new_value = $array[$i];}
                        else $new_value = $new_value ." ". $array[$i];

                    }


                }

            $eISSN=$new_value;



            // fin de la modification

            $emS = $this->entityManager;

            $em = $emS->getRepository(DataTScopus::class);
            $em2 = $emS->getRepository(DataReuters::class);
            $eISSNT = $eISSN;
            $eISSNS = $eISSN;
            $pos = strpos($eISSN, "-");
            $c_number = preg_match('/\\d/', $eISSN);
            if ($c_number == 1) {
                $eISSN=str_ireplace(" ", "", $eISSN);
                if (strlen($eISSN) == 9 || strlen($eISSN) == 8) {
                    if ($pos !== false) {
                        $eISSNS = str_ireplace("-", "", $eISSN);

                    } else {

                        $eISSNT = substr_replace($eISSN, "-", 4, 0);
                        $eISSNS = str_ireplace("-", "", $eISSN);
                    }
                    $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
                    $data_reuters = $em2->findInThomsonByIssn($eISSNT, $emS);




                    // necessite une méthode duplication pour suggerer

                    if ($data_t_scopus != null) {
                        $val_title = $data_t_scopus->getTitle();
                        $pagination_slide=$this->journalFinder->similarResult($val_title);

                        // une fonction pour trouver les valeurs similaires


                    }



                    //




                    if ($data_t_scopus == null && $data_reuters != null) {

                        if ($data_reuters->getEISSN() == $eISSNT && $data_reuters->getISSN() != null) $eISSNS = $data_reuters->getISSN();
                        if ($data_reuters->getISSN() == $eISSNT && $data_reuters->getEISSN() != null) $eISSNS = $data_reuters->getEISSN();
                        $eISSNSend=$eISSNS;
                        $eISSNS = str_replace("-", "", $eISSNS);
                        $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
                    }
                    if ($data_t_scopus != null && $data_reuters == null) {

                        if ($data_t_scopus->getEISSN() == $eISSNS && $data_t_scopus->getPrintISSN() != null) $eISSNT = $data_t_scopus->getPrintISSN();
                        if ($data_t_scopus->getPrintISSN() == $eISSNS && $data_t_scopus->getEISSN() != null) $eISSNT = $data_t_scopus->getEISSN();
                        $eISSNSend=$eISSNT;
                        $eISSNT = substr_replace($eISSNT, "-", 4, 0);
                        $data_reuters = $em2->findInThomsonByIssn($eISSNT, $emS);
                        if ($data_reuters == null) {
                            $eISSNT = $data_t_scopus->getTitle();
                            $eISSNT = str_ireplace("&", "and", $eISSNT);
                            $data_reuters = $em2->findInThomsonByTitle($eISSNT, $emS);
                        }

                    }

                }
            } else {
                $data_t_scopus = $em->findScopusSeveralResultByTitle($eISSNS, $emS);
                if (sizeof($data_t_scopus) == 1) {
                    $eISSNT = str_ireplace("&", "and", $eISSN);

                    $data_t_scopus = $em->findInScopusByTitle($eISSNS, $emS);

                    $data_reuters = $em2->findInThomsonByTitle($eISSNT, $emS);
                    if ($data_t_scopus == null && $data_reuters != null) {

                        if ($data_reuters->getISSN() != null) $eISSNS = $data_reuters->getISSN();
                        $eISSNS = str_ireplace("-", "", $eISSNS);
                        $eISSNSend=$eISSNS;
                        $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
                        if ($data_t_scopus) {
                            if ($data_reuters->getEISSN() != null) $eISSNS = $data_reuters->getEISSN();
                            $eISSNS = str_ireplace("-", "", $eISSNS);
                            $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
                        }
                    }
                    if ($data_t_scopus != null && $data_reuters == null) {
                        if ($data_t_scopus->getPrintISSN() != null) $eISSNT = $data_t_scopus->getPrintISSN();
                        $eISSNT = substr_replace($eISSNT, "-", 4, 0);
                        $eISSNSend=$eISSNT;
                        $data_reuters = $em2->findInThomsonByIssn($eISSNT, $emS);
                        if ($data_reuters == null) {
                            if ($data_t_scopus->getEISSN() != null) $eISSNT = $data_t_scopus->getEISSN();
                            $eISSNT = substr_replace($eISSNT, "-", 4, 0);
                            $data_reuters = $em2->findInThomsonByIssn($eISSNT, $emS);
                        }
                        if ($data_reuters == null) {
                            $eISSNT = $data_t_scopus->getTitle();
                            $eISSNT = $eISSNT = str_ireplace("&", "and", $eISSN);
                            $data_reuters = $em2->findInThomsonByTitle($eISSNT, $emS);
                        }

                    }

                    // ajouter le 12/05/2020





                        $val_title = $eISSNS;
                        $pagination_slide=$this->journalFinder->similarResult($val_title);

                        // une fonction pour trouver les valeurs similaires



                        //fin ajout


                }
                // ajouter le 10/05/2020 pour inverser les valeurs
                if ($data_t_scopus ==  null) {




                        // echo $new_value;
                        $data_t_scopus = $this->journalFinder->similarResult($eISSNS);
                        $pagination_slide=null;
                        //echo sizeof($data_t_scopus);


                }
                // fin ajout
            }
            $pagination=0;
            if(!is_null($data_t_scopus) && is_iterable($data_t_scopus)){
                $pagination = $this->paginator->paginate(
                    $data_t_scopus, /* query NOT result */
                    $request->query->getInt('page', 1), /*page number*/
                   20 /*limit per page*/
                );
            }
        }
        $topjournallistScopus=$em->selectTopListScopus($emS);
        $topjournallistWebofs=$em2->selectTopListWeb($emS);

        return $this->render('default/searchV.html.twig', [
            'form' => $form->createView(),
            'data_reuter' => $data_reuters,
            'data_t_scopus' => $data_t_scopus,
            'tpjlistScopus'=>$topjournallistScopus,
            'tpjlistWebof'=>$topjournallistWebofs,
            'eISSN' => $eISSNSend,
            'pagination'=>$pagination,
            'paginationR'=>$pagination_slide
        ]);
    }

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/journal/{eISSN}", name="data_t_scopus_results")
     */
    public function findValue($eISSN, Request $request)
    {
        $objet = new Search();
        $data_t_scopus = array();
        $data_reuters = array();
        $pagination_slide=null;
        $topjournallistScopus=null;
        $var_title="";
        $form = $this->createForm(SearchType::class, $objet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $eISSN = $form->get("searchValue")->getData();
        }
        $emS = $this->getDoctrine()->getManager();
        $em = $this->entityManager->getRepository(DataTScopus::class);
        $em2 = $this->entityManager->getRepository(DataReuters::class);
        $eISSNT = $eISSN;
        $eISSNS = $eISSN;
        $pos = strpos($eISSN, "-");
        $c_number = preg_match('/\\d/', $eISSN);
        if ($c_number == 1) {
            if (strlen($eISSN) == 9 || strlen($eISSN) == 8) {
                if ($pos !== false) {
                    $eISSNS = str_replace("-", "", $eISSN);

                } else {

                    $eISSNT = substr_replace($eISSN, "-", 4, 0);
                    $eISSNS = str_replace("-", "", $eISSN);
                }
                $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
                $data_reuters = $em2->findInThomsonByIssn($eISSNT, $emS);
                if ($data_t_scopus != null) $var_title=$data_t_scopus->getTitle();
                if ($data_t_scopus == null && $data_reuters != null) {
                    if ($data_reuters->getEISSN() == $eISSNT && $data_reuters->getISSN() != null) $eISSNS = $data_reuters->getISSN();
                    if ($data_reuters->getISSN() == $eISSNT && $data_reuters->getEISSN() != null) $eISSNS = $data_reuters->getEISSN();

                    $eISSNS = str_replace("-", "", $eISSNS);

                    $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
                }
                if ($data_t_scopus != null && $data_reuters == null) {


                    if ($data_t_scopus->getEISSN() == $eISSNS && $data_t_scopus->getPrintISSN() != null) $eISSNT = $data_t_scopus->getPrintISSN();
                    if ($data_t_scopus->getPrintISSN() == $eISSNS && $data_t_scopus->getEISSN() != null) $eISSNT = $data_t_scopus->getEISSN();
                    $eISSNT = substr_replace($eISSNT, "-", 4, 0);
                    $data_reuters = $em2->findInThomsonByIssn($eISSNT, $emS);
                    if ($data_reuters == null) {
                        $eISSNT = $data_t_scopus->getTitle();
                        $var_title=$eISSNT;
                        $eISSNT = str_replace("&", "and", $eISSNT);
                        $data_reuters = $em2->findInThomsonByTitle($eISSNT, $emS);
                    }

                }

            }

        } else {
            $data_t_scopus = $em->findScopusSeveralResultByTitle($eISSNS, $emS);
            if (sizeof($data_t_scopus) == 1) {
                $var_title=$data_t_scopus->getTitle();

                $eISSNT = str_replace("&", "and", $eISSN);

                $data_t_scopus = $em->findInScopusByTitle($eISSNS, $emS);

                $data_reuters = $em2->findInThomsonByTitle($eISSNT, $emS);
                if ($data_t_scopus == null && $data_reuters != null) {

                    if ($data_reuters->getISSN() != null) $eISSNS = $data_reuters->getISSN();
                    $eISSNS = str_replace("-", "", $eISSNS);
                    $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
                    if ($data_t_scopus) {
                        if ($data_reuters->getEISSN() != null) $eISSNS = $data_reuters->getEISSN();
                        $eISSNS = str_replace("-", "", $eISSNS);
                        $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
                    }
                }
                if ($data_t_scopus != null && $data_reuters == null) {

                    if ($data_t_scopus->getPrintISSN() != null) $eISSNT = $data_t_scopus->getPrintISSN();
                    $eISSNT = substr_replace($eISSNT, "-", 4, 0);
                    $data_reuters = $em2->findInThomsonByIssn($eISSNT, $emS);
                    if ($data_reuters == null) {
                        if ($data_t_scopus->getEISSN() != null) $eISSNT = $data_t_scopus->getEISSN();
                        $eISSNT = substr_replace($eISSNT, "-", 4, 0);
                        $data_reuters = $em2->findInThomsonByIssn($eISSNT, $emS);
                    }
                    if ($data_reuters == null) {
                        $eISSNT = $data_t_scopus->getTitle();

                        $eISSNT = $eISSNT = str_ireplace("&", "and", $eISSN);
                        $data_reuters = $em2->findInThomsonByTitle($eISSNT, $emS);
                    }

                }
            }





        }


        // ajouter le 12/05/2020

//echo $var_title;
        if($var_title!="")
        $pagination_slide=$this->journalFinder->similarResult($var_title);

$topjournallistWebofs=$em2->selectTopListWeb($emS);
$topjournallistScopus=$em->selectTopListScopus($emS);



            //fin de modification 10/05
        return $this->render('default/searchV.html.twig', [
            'form' => $form->createView(),
            'data_reuter' => $data_reuters,
            'data_t_scopus' => $data_t_scopus,
            'eISSN' => $eISSN,
            'tpjlistWebof'=>$topjournallistWebofs,
            'tpjlistScopus'=>$topjournallistScopus,
            'paginationR'=>$pagination_slide
        ]);
    }



}
