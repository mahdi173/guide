<?php

namespace App\Controller\Website;

use Sulu\Bundle\CommunityBundle\Manager\UserManagerInterface;
use Sulu\Bundle\SecurityBundle\Entity\User;
use App\Form\UpdatePasswordType;
//use App\Security\SecurityChecker;
use Sulu\Bundle\DocumentManagerBundle\Initializer\Initializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormFactoryInterface;

class UpdatePasswordController extends AbstractController
{

    private $eventDispatcher;

    private $formFactory;

    private $userManager;

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder, EventDispatcherInterface $eventDispatcher)
    {

//        $this->formFactory = $formFactory;
//        $this->userManager = $userManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->encoder = $encoder;

    }


    /**
     * @Route("/update-pw", name="update-password")
     */
    public function edit(Request $request) {

        $em = $this->getDoctrine()->getManager();
//        $user = $this->getUser();
        $user=$this->getUser();

        $form = $this->createForm(UpdatePasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$userpassword=$user->getPassword();
            $oldpassword=$form->get('oldPassword')->getData();
            $passwordValid=$this->encoder->isPasswordValid($user, $oldpassword);
            if($passwordValid){
                $newpwd = $form->get('plainPassword')['first']->getData();
                $user->setPassword($this->encoder->encodePassword($user, $newpwd));
                //$this->userManager->updateUser($user);
                $em->persist($user);
                $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('sulu_community.profile');
            }else{
                $this->addFlash('info','error');

            }
        }

        return $this->render('bundles/SuluCommunityBundle/registration-update-password.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

}
