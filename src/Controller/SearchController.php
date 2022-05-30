<?php


namespace App\Controller;


use App\Entity\DataReuters;
use App\Entity\DataScopus;
use App\Entity\DataTScopus;
use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\JournalRepository;
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
    public function searchByValue(Request $request, JournalRepository $journalRepository, PaginatorInterface $paginator)
    {

        $objet = new Search();
        $data_t_scopus = null;
        $data_reuters = null;
        $pagination_slide = null;
        $topjournallistScopus = null;
        $eISSNSend = null;

        $form = $this->createForm(SearchType::class, $objet);
        //$form->handleRequest($request);

        $searchTerm = $request->get("searchValue", null);
        $searchOption = $request->get("searchOption", "journal");
        if ($searchTerm && 'journal' === $searchOption) {
            $page = $request->get("page", 1);

            $journals = $paginator->paginate($journalRepository->search($request->get("searchValue"), [], $page), $page, 10);

            return $this->render('search/journal-results.html.twig', ['journals' => $journals]);
        }

        if ($request->get("searchValue")) {

            if ($request->get("searchOption")) {
                if ($request->get("searchOption") == "journal")
                {

                    // modification par outmane le 11/05/2020 à 10h00
                    $val = $request->get("searchValue");
                    $array = explode(" ", $val);

                    $new_value = "";

                    for ($i = 0; $i < (count($array)); $i++) {
                        if ($array[$i] != " ") {
                            if ($i == 0) {
                                $new_value = $array[$i];
                            } else $new_value = $new_value . " " . $array[$i];

                        }


                    }

                    $eISSN = $new_value;


                    // fin de la modification

                    $emS = $this->entityManager;

                    $em = $emS->getRepository(DataTScopus::class);
                    $em2 = $emS->getRepository(DataReuters::class);
                    $eISSNT = $eISSN;
                    $eISSNS = $eISSN;
                    $pos = strpos($eISSN, "-");
                    $c_number = preg_match('/\\d/', $eISSN);
                    if ($c_number == 1) {
                        $eISSN = str_ireplace(" ", "", $eISSN);
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
                                $pagination_slide = $this->journalFinder->similarResult($val_title);

                                // une fonction pour trouver les valeurs similaires


                            }


                            //


                            if ($data_t_scopus == null && $data_reuters != null) {

                                if ($data_reuters->getEISSN() == $eISSNT && $data_reuters->getISSN() != null) $eISSNS = $data_reuters->getISSN();
                                if ($data_reuters->getISSN() == $eISSNT && $data_reuters->getEISSN() != null) $eISSNS = $data_reuters->getEISSN();
                                $eISSNSend = $eISSNS;
                                $eISSNS = str_replace("-", "", $eISSNS);
                                $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
                            }
                            if ($data_t_scopus != null && $data_reuters == null) {

                                if ($data_t_scopus->getEISSN() == $eISSNS && $data_t_scopus->getPrintISSN() != null) $eISSNT = $data_t_scopus->getPrintISSN();
                                if ($data_t_scopus->getPrintISSN() == $eISSNS && $data_t_scopus->getEISSN() != null) $eISSNT = $data_t_scopus->getEISSN();
                                $eISSNSend = $eISSNT;
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
                                $eISSNSend = $eISSNS;
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
                                $eISSNSend = $eISSNT;
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
                            $pagination_slide = $this->journalFinder->similarResult($val_title);

                            // une fonction pour trouver les valeurs similaires


                            //fin ajout


                        }
                        // ajouter le 10/05/2020 pour inverser les valeurs
                        if ($data_t_scopus == null) {


                            // echo $new_value;
                            $data_t_scopus = $this->journalFinder->similarResult($eISSNS);
                            $pagination_slide = null;
                            //echo sizeof($data_t_scopus);


                        }
                        // fin ajout
                    }
                    $pagination = 0;
                    if (!is_null($data_t_scopus) && is_iterable($data_t_scopus)) {
                        $pagination = $this->paginator->paginate(
                            $data_t_scopus, /* query NOT result */
                            $request->query->getInt('page', 1), /*page number*/
                            5 /*limit per page*/
                        );
                    }
                }
                if ($request->get('searchOption') == "author") {

                    return $this->redirectToRoute('get_authors', ['authorValue' => $request->get("searchValue")]);
                }

                $topjournallistScopus = $em->selectTopListScopus($emS);
                $topjournallistWebofs = $em2->selectTopListWeb($emS);

                //echo sizeof($publishers);
                return $this->render('default/searchV.html.twig', [
                    'form' => $form->createView(),
                    'data_reuter' => $data_reuters,
                    'data_t_scopus' => $data_t_scopus,
                    'tpjlistScopus' => $topjournallistScopus,
                    'tpjlistWebof' => $topjournallistWebofs,
                    'eISSN' => $eISSNSend,

                    'pagination' => $pagination,
                    'paginationR' => $pagination_slide
                ]);
            }
            else{
                //journal

                // modification par outmane le 11/05/2020 à 10h00
                $val = $request->get("searchValue");
                $array = explode(" ", $val);

                $new_value = "";

                for ($i = 0; $i < (count($array)); $i++) {
                    if ($array[$i] != " ") {
                        if ($i == 0) {
                            $new_value = $array[$i];
                        } else $new_value = $new_value . " " . $array[$i];

                    }


                }

                $eISSN = $new_value;


                // fin de la modification

                $emS = $this->entityManager;

                $em = $emS->getRepository(DataTScopus::class);
                $em2 = $emS->getRepository(DataReuters::class);
                $eISSNT = $eISSN;
                $eISSNS = $eISSN;
                $pos = strpos($eISSN, "-");
                $c_number = preg_match('/\\d/', $eISSN);
                if ($c_number == 1) {
                    $eISSN = str_ireplace(" ", "", $eISSN);
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
                            $pagination_slide = $this->journalFinder->similarResult($val_title);

                            // une fonction pour trouver les valeurs similaires


                        }


                        //


                        if ($data_t_scopus == null && $data_reuters != null) {

                            if ($data_reuters->getEISSN() == $eISSNT && $data_reuters->getISSN() != null) $eISSNS = $data_reuters->getISSN();
                            if ($data_reuters->getISSN() == $eISSNT && $data_reuters->getEISSN() != null) $eISSNS = $data_reuters->getEISSN();
                            $eISSNSend = $eISSNS;
                            $eISSNS = str_replace("-", "", $eISSNS);
                            $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
                        }
                        if ($data_t_scopus != null && $data_reuters == null) {

                            if ($data_t_scopus->getEISSN() == $eISSNS && $data_t_scopus->getPrintISSN() != null) $eISSNT = $data_t_scopus->getPrintISSN();
                            if ($data_t_scopus->getPrintISSN() == $eISSNS && $data_t_scopus->getEISSN() != null) $eISSNT = $data_t_scopus->getEISSN();
                            $eISSNSend = $eISSNT;
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
                            $eISSNSend = $eISSNS;
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
                            $eISSNSend = $eISSNT;
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
                        $pagination_slide = $this->journalFinder->similarResult($val_title);

                        // une fonction pour trouver les valeurs similaires


                        //fin ajout


                    }
                    // ajouter le 10/05/2020 pour inverser les valeurs
                    if ($data_t_scopus == null) {


                        // echo $new_value;
                        $data_t_scopus = $this->journalFinder->similarResult($eISSNS);
                        $pagination_slide = null;
                        //echo sizeof($data_t_scopus);


                    }
                    // fin ajout
                }
                $pagination = 0;
                if (!is_null($data_t_scopus) && is_iterable($data_t_scopus)) {
                    $pagination = $this->paginator->paginate(
                        $data_t_scopus, /* query NOT result */
                        $request->query->getInt('page', 1), /*page number*/
                        5 /*limit per page*/
                    );
                }
                //journal
                $topjournallistScopus = $em->selectTopListScopus($emS);
                $topjournallistWebofs = $em2->selectTopListWeb($emS);
                //echo sizeof($publishers);
                return $this->render('default/searchV.html.twig', [
                    'form' => $form->createView(),
                    'data_reuter' => $data_reuters,
                    'data_t_scopus' => $data_t_scopus,
                    'tpjlistScopus' => $topjournallistScopus,
                    'tpjlistWebof' => $topjournallistWebofs,
                    'eISSN' => $eISSNSend,

                    'pagination' => $pagination,
                    'paginationR' => $pagination_slide
                ]);
            }

        }

        return $this->redirectToRoute('homepage');

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
                    $eISSNT=str_replace("-", "", $eISSNT);
                    $eISSNT = substr_replace($eISSNT, "-", 4, 0);
                    $data_reuters = $em2->findInThomsonByIssn($eISSNT, $emS);
                    if ($data_reuters == null) {
                        if ($data_t_scopus->getEISSN() != null) $eISSNT = $data_t_scopus->getEISSN();
                        $eISSNT=str_replace("-", "", $eISSNT);
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


    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/advanced-search", name="advanced_search_scopus_web_ofs")
     */
    public function advanced_search_params(){


        $data_t_scopus = null;
        $data_reuters = null;
        $data_t_advanced_scopus = null;
        $data_advanced_reuters = null;
        $categories=null;
        $publishers=null;
        $var_title="";


        $emS = $this->getDoctrine()->getManager();
        $em = $this->entityManager->getRepository(DataTScopus::class);
        $categories=$em->selectALLCategories($emS);
        $publishers=$em->selectALLPublishers($emS);
        $show_advanced=1;
        //echo sizeof($publishers);
        return $this->render('default/searchV.html.twig', [

            'data_reuter' => $data_reuters,
            'data_t_scopus' => $data_t_scopus,
            //'data_reuter_advanced' => $data_advanced_reuters,
            //'data_t_scopus_advanced' => $data_t_advanced_scopus,
            'listcategories'=>$categories,
            'listpublishers'=>$publishers,
            'show_ad'=>$show_advanced

        ]);
    }


    /**
     *
     * @Route("/advanced_query", name="data__advanced_search_by_several_params")
     */
    public function advancedsearchByParams(Request $request)
    {
        $emS = $this->getDoctrine()->getManager();
        $em = $this->entityManager->getRepository(DataTScopus::class);
        $em2 = $this->entityManager->getRepository(DataReuters::class);
        $categories=$em->selectALLCategories($emS);
        $publishers=$em->selectALLPublishers($emS);
        $objet = new Search();
        $data_t_advanced_scopus = null;
        $data_advanced_reuters = null;
        $data_t_scopus = array();
        $data_intermediate= array();
        $data_reuters = array();
        $sjr_value=0;
        $show_advanced=1;

        $form = $this->createForm(SearchType::class, $objet);
        $publisher= $request->get('name_of_publisher');
        $subject_area=$request->get('subjectarea');
        $openaccess_yes= $request->get('yes');
        $openaccess_no= $request->get('no');



        $j=0;
        $ta_openaccs=null;
        if($openaccess_yes=="yes"){
            $ta_openaccs[$j]="YES";
            $j=$j+1;
        }
        if($openaccess_no=="no"){
            $ta_openaccs[$j]="NO";
        }
        if($ta_openaccs==null){
            $ta_openaccs[0]="NO";
            $ta_openaccs[1]="YES";
        }
        $i=0;
        $tab_qrtle=null;
        $qrtl1=$request->get('q1');

        if($qrtl1=="Quartile 1"){
            $tab_qrtle[$i]="Quartile 1";
            $i=$i+1;
        }
        $qrtl2=$request->get('q2');
        if($qrtl2=="Quartile 2"){
            $tab_qrtle[$i]="Quartile 2";
            $i=$i+1;
        }
        $qrtl3=$request->get('q3');
        if($qrtl3=="Quartile 3"){
            $tab_qrtle[$i]="Quartile 3";
            $i=$i+1;
        }
        $qrtl4=$request->get('q4');
        if($qrtl4=="Quartile 4"){
            $tab_qrtle[$i]="Quartile 4";

        }

        if( $tab_qrtle==null){
            $tab_qrtle[0]="Quartile 1";
            $tab_qrtle[1]="Quartile 2";
            $tab_qrtle[2]="Quartile 3";
            $tab_qrtle[3]="Quartile 4";
        }
        $operation="op1";
        if($request->get('sjr_r')=="option1")
        {

            $sjr_value=$request->get('sjr_sup');
            $sjr_value=str_replace(".", ",", $sjr_value);
            $operation="op1";
        }
        elseif($request->get('sjr_r')=="option2"){
            $sjr_value=$request->get('sjr_inf');
            $sjr_value=str_replace(".", ",", $sjr_value);
            $operation="op2";
        }
        else {$sjr_value=0;
            $operation="op1";
        }
        if($publisher=="All" && $subject_area=="All"){
            $data_t_advanced_scopus=$em->selectForAdvancesearchWithoutSubjectAndPublisher($emS, $tab_qrtle, $ta_openaccs, $sjr_value, $operation);
        }
        elseif ($publisher!="All" && $subject_area=="All")
        {

            $data_t_advanced_scopus=$em->selectForAdvancesearchWithoutSubjectarea($em,$publisher, $tab_qrtle, $ta_openaccs, $sjr_value, $operation);
        }
        elseif ($publisher=="All" && $subject_area!="All")
        {

            $data_t_advanced_scopus=$em->selectForAdvancesearchWithoutPublisher($em,$subject_area, $tab_qrtle, $ta_openaccs, $sjr_value, $operation);
        }
        elseif($request->get('sjr_r')=="option1" && $request->get('sjr_sup')!="" ){

            $sjr_value=$request->get('sjr_sup');
            $data_t_advanced_scopus=$em->selectForAdvancesearch($emS,$publisher, $subject_area, $tab_qrtle ,$ta_openaccs, $sjr_value, $operation);
        }elseif($request->get('sjr_r')=="option2" && $request->get('sjr_inf')!="" ){

            $sjr_value=$request->get('sjr_inf');
            $data_t_advanced_scopus=$em->selectForAdvancesearchSJRInf($emS,$publisher, $subject_area, $tab_qrtle ,$ta_openaccs, $sjr_value);
        }






        if($request->get('jcr_r')=="option1" || $request->get('jcr_r')=="option2")
        {

            $journal_inst=null;
            $i=0;
            foreach ($data_t_advanced_scopus as $journal){
                $eISSNTP="";
                $eISSNTE="";
                if ($journal->getPrintISSN() != null){ $eISSNTP = $journal->getPrintISSN();


                    $eISSNTP = substr_replace($eISSNTP, "-", 4, 0);
                    $journal_inst = $em2->findInThomsonByIssn($eISSNTP, $emS);
                    //echo $journal_inst;
                }
                if ($journal_inst == null) {
                    if ($journal->getEISSN() != null) $eISSNTE = $journal->getEISSN();
                    $eISSNTE = substr_replace($eISSNTE, "-", 4, 0);

                    $journal_inst = $em2->findInThomsonByIssn($eISSNTE, $emS);

                }
                if ($journal_inst != null) {
                    if ($request->get('jcr_r') == "option1"){
                        $jcr_value=$request->get('jcr_sup');
                        $jcr_value=str_replace(",", ".", $jcr_value);
                        if ($journal_inst->getJournalimpactfactor() != null && $journal_inst->getJournalimpactfactor() >= $jcr_value) {
                            $data_intermediate[$i] = $journal;
                            $i = $i + 1;
                        }
                    }
                    elseif ($request->get('jcr_r') == "option2"){
                        $jcr_value=$request->get('jcr_inf');
                        $jcr_value=str_replace(",", ".", $jcr_value);
                        if ($journal_inst->getJournalimpactfactor() != null && $journal_inst->getJournalimpactfactor() <= $jcr_value || $journal_inst->getJournalimpactfactor() =="Not Available" ) {
                            $data_intermediate[$i] = $journal;
                            $i = $i + 1;
                        }
                    }
                }


            }
        }

        if($data_intermediate!=null)$data_t_advanced_scopus=$data_intermediate;
        $pagination=0;
        if(!is_null($data_t_advanced_scopus) && is_iterable($data_t_advanced_scopus)){
            $pagination = $this->paginator->paginate(
                $data_t_advanced_scopus, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                5 /*limit per page*/
            );
        }
        return $this->render('default/searchV.html.twig', [

            'data_reuter_advanced' => $data_advanced_reuters,
            'data_t_scopus_advanced' => $data_t_advanced_scopus,
            'data_reuter' => $data_reuters,
            'data_t_scopus' => $data_t_scopus,
            'listcategories'=>$categories,
            'listpublishers'=>$publishers,
            'pagination'=>$pagination,
            'show_ad'=>$show_advanced

        ]);
    }

    /**
     * Lists all data_t_scopus entities for one publisher or subject area or quartlle.
     *
     * @Route("/search_journal_query", name="search_journals_for_scopus")
     */
    public function search_journal_for(Request $request)
    {
        $emS = $this->getDoctrine()->getManager();
        $em = $this->entityManager->getRepository(DataTScopus::class);

        $data_t_scopus = array();
        $data_reuters=null;
        $objet = new Search();
        $val="";
        if ($request->get("quartile")) {


            $val = $request->get("quartile");
            $data_t_scopus = $em->selectByQuartlle($emS, $val);}
        else if ($request->get("subject_area")) {


            $val = $request->get("subject_area");
            $data_t_scopus = $em->selectOneSubjectarea($emS, $val);}
        else if ($request->get("publisher")) {


            $val = $request->get("publisher");
            $data_t_scopus = $em->selectonepublisher($emS, $val);}


        $pagination=0;
        if(!is_null($data_t_scopus) && is_iterable($data_t_scopus)){
            $pagination = $this->paginator->paginate(
                $data_t_scopus, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                5 /*limit per page*/
            );
        }


        return $this->render('default/searchV.html.twig', [

            'data_t_scopus' => $data_t_scopus,

            'data_reuter' => $data_reuters,
            'pagination'=>$pagination,

        ]);
    }

}
