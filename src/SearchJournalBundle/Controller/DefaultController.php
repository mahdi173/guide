<?php

namespace SearchJournalBundle\Controller;
use JournalBundle\Entity\data_t_scopus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {

        return $this->render('SearchJournalBundle:Default:index.html.twig');
    }

}
