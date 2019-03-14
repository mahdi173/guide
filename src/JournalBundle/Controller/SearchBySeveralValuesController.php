<?php

namespace JournalBundle\Controller;
use JournalBundle\Entity\Search;
use JournalBundle\Entity\data_reuters;
use JournalBundle\Entity\data_t_scopus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
class SearchBySeveralValuesController extends Controller
{


    /**
     *
     * @Route("/", name="data_search_by_several_values")
     */
    public function searchByValue(Request $request){

        $objet= new Search();
        $data_t_scopus =null;
        $data_reuters=null;
        $form = $this->createForm('JournalBundle\Form\SearchType', $objet);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $eISSN=$form->get("searchValue")->getData();
            $emS = $this->getDoctrine()->getManager();
            $em = new data_t_scopus();
            $em2=new data_reuters();
            $eISSNT = $eISSN;
            $eISSNS = $eISSN;
            $pos = strpos($eISSN, "-");
            $c_number= preg_match('/\\d/', $eISSN);
            if($c_number==1) {
                if(strlen($eISSN)==9 || strlen($eISSN)==8){
                if ($pos !== false) {
                    $eISSNS = str_replace("-", "", $eISSN);

                } else {

                    $eISSNT = substr_replace($eISSN, "-", 4, 0);
                    $eISSNS = str_replace("-", "", $eISSN);
                }
                $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
                $data_reuters = $em2->findInThomsonByIssn($eISSNT, $emS);

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
                        $eISSNT = str_replace("&", "and", $eISSNT);
                        $data_reuters = $em2->findInThomsonByTitle($eISSNT, $emS);
                    }

                }

            }
            }
            else {
                $data_t_scopus = $em->findScopusSeveralResultByTitle($eISSNS, $emS);
                if(sizeof($data_t_scopus)==1) {
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
                            $eISSNT = $eISSNT = str_replace("&", "and", $eISSN);
                            $data_reuters = $em2->findInThomsonByTitle($eISSNT, $emS);
                        }

                    }
                }

            }
        }

        return $this->render(':default:searchV.html.twig',[
            'form'=>$form->createView(),
            'data_reuter' => $data_reuters, 'data_t_scopus'=>$data_t_scopus
        ]);
    }
    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/{eISSN}", name="data_t_scopus_results")
     */
    public function findValue($eISSN, Request $request){
        $objet= new Search();
        $data_t_scopus =array();
        $data_reuters=array();
        $form = $this->createForm('JournalBundle\Form\SearchType', $objet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $eISSN = $form->get("searchValue")->getData();
        }
        $emS = $this->getDoctrine()->getManager();
        $em = new data_t_scopus();
        $em2=new data_reuters();
        $eISSNT = $eISSN;
        $eISSNS = $eISSN;
        $pos = strpos($eISSN, "-");
        $c_number= preg_match('/\\d/', $eISSN);
        if($c_number==1 && strlen($eISSN)==9 || strlen($eISSN)==8) {
            if ($pos !== false) {
                $eISSNS = str_replace("-", "", $eISSN);

            } else {

                $eISSNT = substr_replace($eISSN, "-", 4, 0);
                $eISSNS = str_replace("-", "", $eISSN);
            }
            $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
            $data_reuters = $em2->findInThomsonByIssn($eISSNT, $emS);

            if($data_t_scopus==null && $data_reuters!=null){
                if($data_reuters->getEISSN()==$eISSNT && $data_reuters->getISSN()!=null)$eISSNS=$data_reuters->getISSN();
                if($data_reuters->getISSN()==$eISSNT && $data_reuters->getEISSN()!=null)$eISSNS=$data_reuters->getEISSN();

                $eISSNS = str_replace("-", "", $eISSNS);

                $data_t_scopus = $em->findInScopusByIssn($eISSNS, $emS);
            }
            if($data_t_scopus!=null && $data_reuters==null){
                if($data_t_scopus->getEISSN()==$eISSNS && $data_t_scopus->getPrintISSN()!=null)$eISSNT=$data_t_scopus->getPrintISSN();
                if($data_t_scopus->getPrintISSN()==$eISSNS && $data_t_scopus->getEISSN()!=null)$eISSNT=$data_t_scopus->getEISSN();
                $eISSNT = substr_replace($eISSNT, "-", 4, 0);
              $data_reuters = $em2->findInThomsonByIssn($eISSNT, $emS);
                if ($data_reuters == null) {
                    $eISSNT = $data_t_scopus->getTitle();
                    $eISSNT = str_replace("&", "and", $eISSNT);
                    $data_reuters = $em2->findInThomsonByTitle($eISSNT, $emS);
                }
            }
        }
        else {

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
                    if ($data_reuters == null) {
                        $eISSNT = $data_t_scopus->getTitle();
                        $eISSNT = str_replace("&", "and", $eISSNT);
                        $data_reuters = $em2->findInThomsonByTitle($eISSNT, $emS);
                    }
                }
            }
            if ($data_t_scopus == null){
                $data_t_scopus = $em->findScopusSeveralResultByTitle($eISSNS, $emS);

            }
        }
        return $this->render(':default:searchV.html.twig',[
            'form'=>$form->createView(),
            'data_reuter' => $data_reuters, 'data_t_scopus'=>$data_t_scopus
        ]);
    }
}
