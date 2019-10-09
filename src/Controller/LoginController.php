<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/user-check", name="user_check")
     */
    public function index(Request $request)
    {
        $authChecker = $this->container->get('security.authorization_checker');
        $router = $this->container->get('router');

        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($router->generate('admin_home'), 307);
        }

        if ($authChecker->isGranted('ROLE_USER')) {
            return new RedirectResponse($router->generate('member_home'), 307);
        }
    }
}
