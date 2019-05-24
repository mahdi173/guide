<?php

namespace JournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RConfidController extends Controller
{
    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/guidejournal/privacy", name="privacy_page")
     */
    public function returnAbout(){
        return $this->render(':addpages:privacy.html.twig');
    }
}
