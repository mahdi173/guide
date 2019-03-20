<?php

namespace JournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AboutController extends Controller
{
    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/about", name="about_guidejournal")
     */
public function returnAbout(){
    return $this->render(':about:about.html.twig');
}
}
