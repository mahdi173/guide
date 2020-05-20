<?php

namespace App\Controller;

use App\Entity\Allpublications;
use App\Entity\Conference;
use App\Form\AllPublicationCreateType;
use App\Form\AllPublicationType;
use App\Form\ConferenceType;
use App\Repository\AllPublicationRepository;
use App\Repository\ConferenceRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/{_locale}/conference")
 */
class ConferenceController extends AbstractController
{
    /**
     * @Route("/", name="conference_index", methods={"GET","POST"})
     */
//    public function index(ConferenceRepository $conferenceRepository): Response
//    {
//        return $this->render('conference/index.html.twig', [
//            'conferences' => $conferenceRepository->findAll(),
//        ]);
//    }
    public function index(Request $request,AllPublicationRepository $publicationRepository): Response
    {
        $publication=new Allpublications();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(AllPublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pub=$em->getRepository(Allpublications::class)->find($form['idPublication']->getData());

            $pub->setTitle($form['title']->getData());
            $pub->setType($form['type']->getData());
            $pub->setName($form['name']->getData());
            $pub->setVolume($form['volume']->getData());
            $pub->setYear($form['year']->getData());
            $pub->setUrl($form['url']->getData());

            $em->persist($pub);
            $em->flush();

            return $this->redirectToRoute('conference_index');
        }

        $form_create = $this->createForm(AllPublicationCreateType::class, $publication);
        $form_create->handleRequest($request);

        if ($form_create->isSubmitted() && $form_create->isValid()) {

            $publication->setUser($this->getUser());
            $em->persist($publication);
            $em->flush();

            return $this->redirectToRoute('conference_index');
        }
        return $this->render('conference/publication_conference.html.twig', [
            'publications' => $publicationRepository->findPublicationByType('conference',$this->getUser()),
            'form' => $form->createView(),
            'form2' => $form_create->createView(),
        ]);
    }
    /**
     *
     * @Route("/new", name="conference_new", methods={"GET","POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conference);
            $entityManager->flush();

            return $this->redirectToRoute('conference_index');
        }

        return $this->render('conference/new.html.twig', [
            'conference' => $conference,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="conference_show", methods={"GET"})
     */
    public function show(Conference $conference): Response
    {
        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="conference_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Conference $conference): Response
    {
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conference_index');
        }

        return $this->render('conference/edit.html.twig', [
            'conference' => $conference,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="conference_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Conference $conference): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conference->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($conference);
            $entityManager->flush();
        }

        return $this->redirectToRoute('conference_index');
    }
}
