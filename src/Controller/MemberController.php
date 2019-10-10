<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/member", name="member_area")
     */
    public function index(Request $request)
    {
        $authChecker = $this->get('security.authorization_checker');

        if ($authChecker->isGranted('ROLE_USER')) {
            return $this->render(
                'member.html.twig'
            );;
        }
    }
}
