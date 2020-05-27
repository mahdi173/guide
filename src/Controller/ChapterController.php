<?php

namespace App\Controller;

use App\Entity\Allpublications;
use App\Entity\Chapter;
use App\Form\AllPublicationCreateType;
use App\Form\AllPublicationType;
use App\Form\ChapterType;
use App\Repository\AllPublicationRepository;
use App\Repository\ChapterRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/{_locale}/profile/chapter")
 */
class ChapterController extends AbstractController
{
    /**
     * @Route("/", name="chapter_index", methods={"GET","POST"})
     */
//    public function index(ChapterRepository $chapterRepository): Response
//    {
//        return $this->render('chapter/index.html.twig', [
//            'chapters' => $chapterRepository->findAll(),
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

            return $this->redirectToRoute('chapter_index');
        }

        $form_create = $this->createForm(AllPublicationCreateType::class, $publication);
        $form_create->handleRequest($request);

        if ($form_create->isSubmitted() && $form_create->isValid()) {

            $publication->setUser($this->getUser());
            $em->persist($publication);
            $em->flush();

            return $this->redirectToRoute('chapter_index');
        }

        return $this->render('chapter/publication_chapter.html.twig', [
            'publications' => $publicationRepository->findPublicationByType('chapter'),
            'form' => $form->createView(),
            'form2' => $form_create->createView(),
        ]);
    }
    /**
     * @Route("/new", name="chapter_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $chapter = new Chapter();
        $form = $this->createForm(ChapterType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chapter);
            $entityManager->flush();

            return $this->redirectToRoute('chapter_index');
        }

        return $this->render('chapter/new.html.twig', [
            'chapter' => $chapter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chapter_show", methods={"GET"})
     */
    public function show(Chapter $chapter): Response
    {
        return $this->render('chapter/show.html.twig', [
            'chapter' => $chapter,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="chapter_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Chapter $chapter): Response
    {
        $form = $this->createForm(ChapterType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chapter_index');
        }

        return $this->render('chapter/edit.html.twig', [
            'chapter' => $chapter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chapter_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Chapter $chapter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chapter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chapter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('chapter_index');
    }
}
