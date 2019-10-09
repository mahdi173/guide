<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MemberController
 * @package App\Controller
 *
 * @Route("/member")
 * @IsGranted("ROLE_USER")
 */
class MemberController extends AbstractController
{
    /**
     * @Route("/", name="member_home")
     */
    public function index()
    {
        return $this->render(
            'member.html.twig'
        );
    }
}
