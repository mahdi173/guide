<?php

namespace App\Controller\Website;

use App\Security\SecurityChecker;
use Sulu\Bundle\DocumentManagerBundle\Initializer\Initializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController
 * @package App\Controller\Website
 */
class RegistrationController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route("/a/registration")
     */
    public function register(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('username')
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $username = $form->get('username')->getData();

            $this->initializeWebspace($username);
        }

        return $this->render('registration/register.html.twig', ['form'=> $form->createView()]);
    }

    private function initializeWebspace($username)
    {
        $content = $this->renderView('skeletons/webspace.xml.twig', ['key'=> $username]);
        $fs = new Filesystem();

        $fs->dumpFile(__DIR__.'/../../../config/webspaces/'.$username.'.xml', $content);

        /** @var Initializer $initializer */
        //$initializer = $this->get("sulu_document_manager.initializer");

        //$initializer->initialize();
    }
}