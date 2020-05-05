<?php

namespace App\Controller;

use App\Entity\Allpublications;
use App\Entity\Publication;
use App\Form\AllPublicationCreateType;
use App\Form\AllPublicationType;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/{_locale}/profile/publication")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("/", name="publication_index", methods={"GET","POST"})
     */
    public function index(Request $request,PublicationRepository $publicationRepository): Response
    {
        $publication=new Allpublications();
        $em=$this->getDoctrine()->getManager();
        $pubs=$publicationRepository->findAll();
        $pubss=$em->getRepository(Allpublications::class)->findBy(['user'=>$this->getUser()]);

        $form = $this->createForm(AllPublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_index');
        }

        $form_create = $this->createForm(AllPublicationCreateType::class, $publication);
        $form_create->handleRequest($request);

        if ($form_create->isSubmitted() && $form_create->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $publication->setUser($this->getUser());
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('publication_index');
        }


        return $this->render('publication/index.html.twig', [
            'publications' => $pubss,
            'publication' => $publication,
            'form' => $form->createView(),
            'form2' => $form_create->createView(),
        ]);
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
