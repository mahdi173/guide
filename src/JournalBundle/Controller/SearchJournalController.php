<?php

namespace JournalBundle\Controller;

use JournalBundle\Entity\data_reuters;
use JournalBundle\Entity\data_t_scopus;
use JournalBundle\Entity\Search;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Data_t_scopus controller.
 *
 * @Route("resultresearch")
 */
class SearchJournalController extends Controller
{
    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/V", name="data_t_scopus_index1")
     * @Method("GET")
     */
    public function indexAction($eISSN)
    {
        $eISSNT=$eISSN;
        $eISSNS=$eISSN;
        $pos = strpos($eISSN, "-");
        if ($pos !== false) {
            $eISSNS = str_replace("-", "", $eISSN);

        }
        else {

            $eISSNT = substr_replace($eISSN, "-", 4, 0);
            $eISSNS = str_replace("-", "", $eISSN);
        }
        $emS = $this->getDoctrine()->getManager();
        $em = new data_t_scopus();
$em2=new data_reuters();
        $data_t_scopus = $em->findInScopus($eISSNS, $emS);
        $data_reuters  = $em2->findInThomson($eISSNT, $emS);
            return $this->render('data_reuters/thomson.html.twig', array(
                'data_reuter' => $data_reuters, 'data_t_scopus'=>$data_t_scopus
            ));
    }

}
