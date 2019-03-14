<?php

namespace JournalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/defaulttest")
     */
    public function indexAction()
    {
        return $this->render('JournalBundle:Default:index.html.twig');
    }
}
