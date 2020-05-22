<?php

namespace App\Controller;

use App\Entity\Allpublications;
use App\Entity\Publication;
use App\Form\AllPublicationCreateType;
use App\Form\AllPublicationType;
use App\Form\PublicationType;
use App\Repository\AllPublicationRepository;
use App\Repository\ContactRepository;
use App\Repository\PublicationRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/profile")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("/{firstname}.{lastname}", name="publication_index", methods={"GET","POST"}, defaults={"lastname" = ""})
     */
    public function index(Request $request, UserRepository $userRepository, ContactRepository $contactRepository, PublicationRepository $publicationRepository, AllPublicationRepository $allPublicationRepository): Response
    {
        $user = $this->getUser();
        $firstName = $request->get('firstname');
        $lastName = $request->get('lastname');

        if ($firstName && $lastName || ($firstName || $lastName)) {
            $user = $userRepository->userFromConctact($firstName, $lastName);

            if ($user) {
                $user = $user[0];
            }

        }

        if ($user) {

            $publication = new Allpublications();
            $myProfile = false;

            $em = $this->getDoctrine()->getManager();
            $pubs = $publicationRepository->findAll();
            $pubss = $allPublicationRepository->allPublications($user);

            $form = null;
            $form_create = null;
            $form_view = null;
            $form_create_view = null;

            if ($user == $this->getUser()) {
                $myProfile = true;
                $form = $this->createForm(AllPublicationType::class, $publication);
                $form->handleRequest($request);
                $form_view = $form->createView();

                if ($form->isSubmitted() && $form->isValid()) {
                    $pub = $em->getRepository(Allpublications::class)->find($form['idPublication']->getData());

                    $pub->setTitle($form['title']->getData());
                    $pub->setType($form['type']->getData());
                    $pub->setName($form['name']->getData());
                    $pub->setVolume($form['volume']->getData());
                    $pub->setYear($form['year']->getData());
                    $pub->setUrl($form['url']->getData());

                    $em->persist($pub);
                    $em->flush();

//            return $this->redirectToRoute('publication_index');
                    return $this->redirectToRoute('publication_index', ['firstname' => $firstName, "lastname" => $lastName]);
                }


                $form_create = $this->createForm(AllPublicationCreateType::class, $publication);
                $form_create->handleRequest($request);
                $form_create_view = $form_create->createView();

                if ($form_create->isSubmitted() && $form_create->isValid()) {

                    $publication->setUser($this->getUser());
                    $em->persist($publication);
                    $em->flush();

//            return $this->redirectToRoute('publication_index');
                    return $this->redirectToRoute('publication_index', ['firstname' => $firstName, "lastname" => $lastName]);
                }
            }

            return $this->render('publication/index.html.twig', [
                'publications' => $pubss,
                'publication' => $publication,
                'form' => $form_view,
                'form2' => $form_create_view,
                'myProfile' => $myProfile,
                'user' => $user,
            ]);
        }
        else{
            return $this->render("Profile/profile_not_found.html.twig");
        }
    }




    /**
     * @Route("/new", name="publication_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $publication->setUser($this->getUser());
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('publication_index');
        }

        return $this->render('publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publication_show", methods={"GET"})
     */
    public function show(Publication $publication): Response
    {
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/{id}", name="all_publication_show", methods={"GET"})
     */
    public function show_all_publications(Allpublications $publication): Response
    {
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/profile_not_found", name="profile_not_found")
     */
    public function profile_not_found()
    {
        return $this->render("Profile/profile_not_found.html.twig");
    }

    /**
     * @Route("/{id}/edit", name="publication_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Publication $publication): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_index');
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publication_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Publication $publication): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('publication_index');
    }
}
