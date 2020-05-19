<?php

namespace App\Controller;

use App\Entity\Allpublications;
use App\Entity\Book;
use App\Form\AllPublicationCreateType;
use App\Form\AllPublicationType;
use App\Form\BookType;
use App\Repository\AllPublicationRepository;
use App\Repository\BookRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/{_locale}/profile/book")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="book_index", methods={"GET","POST"})
     */
//    public function index(BookRepository $bookRepository): Response
//    {
//        return $this->render('book/index.html.twig', [
//            'books' => $bookRepository->findAll(),
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

            return $this->redirectToRoute('book_index');
        }

        $form_create = $this->createForm(AllPublicationCreateType::class, $publication);
        $form_create->handleRequest($request);

        if ($form_create->isSubmitted() && $form_create->isValid()) {

            $publication->setUser($this->getUser());
            $em->persist($publication);
            $em->flush();

            return $this->redirectToRoute('book_index');
        }
        return $this->render('book/publication_book.html.twig', [
            'publications' => $publicationRepository->findPublicationByType('book',$this->getUser()),
            'form' => $form->createView(),
            'form2' => $form_create->createView(),
        ]);
    }

    /**
     * @Route("/new", name="book_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="book_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Book $book): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('book_index');
    }
}
