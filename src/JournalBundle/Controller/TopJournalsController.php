<?php

namespace JournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TopJournalsController extends Controller
{
    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/scopus/topjournallist", name="top_journal_page")
     */
    public function returntop(){
        return $this->render(':addpages:best.html.twig');

    }
}
