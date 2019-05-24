<?php

namespace JournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class IServicesController extends Controller
{
    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/indexing/services", name="services_page")
     */
    public function returnAbout(){
        return $this->render(':addpages:indexservices.html.twig');
    }
}
