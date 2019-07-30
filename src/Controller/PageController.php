<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/aboutguidejournal", name="about_guidejournal")
     */
    public function returnAbout(){
        return $this->render(':about:about.html.twig');
    }
}