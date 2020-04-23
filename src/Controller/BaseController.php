<?php


namespace App\Controller;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/{_locale}/profile/conference")
 */
class BaseController extends AbstractController
{
    /**
     * @Route("/author_search", name="author_search", methods={"GET"})
     */
    public function index()
    {
        return $this->render('authors/author_search.html.twig', [

        ]);
    }
}
