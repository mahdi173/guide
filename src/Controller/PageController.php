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
    public function about(){
        return $this->render('about/about.html.twig');
    }

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/contactguidejournal", name="contact_guidejournal")
     */
    public function contact(){
        return $this->render('contact/contact.html.twig');
    }

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/indexing/services", name="services_page")
     */
    public function indexingServices(){
        return $this->render('addpages/indexservices.html.twig');
    }

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/guidejournal/privacy", name="privacy_page")
     */
    public function privacy(){
        return $this->render('addpages/privacy.html.twig');
    }

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/scopus/topjournallist", name="top_journal_page")
     */
    public function topJournal()
    {
        return $this->render('addpages/best.html.twig');

    }
}
