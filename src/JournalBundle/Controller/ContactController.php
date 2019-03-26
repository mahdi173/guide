<?php

namespace JournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ContactController extends Controller
{
    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/contactguidejournal", name="contact_guidejournal")
     */
    public function returnAbout(){
        return $this->render(':contact:contact.html.twig');
    }
}
