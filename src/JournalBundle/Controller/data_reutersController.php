<?php

namespace JournalBundle\Controller;

use JournalBundle\Entity\data_reuters;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Data_reuter controller.
 *
 * @Route("data_reuters")
 */
class data_reutersController extends Controller
{
    /**
     * Lists all data_reuter entities.
     *
     * @Route("/", name="data_reuters_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $data_reuters = $em->getRepository('JournalBundle:data_reuters')->findAll();

        return $this->render('data_reuters/index.html.twig', array(
            'data_reuters' => $data_reuters,
        ));
    }

    /**
     * Creates a new data_reuter entity.
     *
     * @Route("/new", name="data_reuters_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $data_reuter = new Data_reuter();
        $form = $this->createForm('JournalBundle\Form\data_reutersType', $data_reuter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($data_reuter);
            $em->flush();

            return $this->redirectToRoute('data_reuters_show', array('id' => $data_reuter->getId()));
        }

        return $this->render('data_reuters/new.html.twig', array(
            'data_reuter' => $data_reuter,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a data_reuter entity.
     *
     * @Route("/{id}", name="data_reuters_show")
     * @Method("GET")
     */
    public function showAction(data_reuters $data_reuter)
    {
        $deleteForm = $this->createDeleteForm($data_reuter);

        return $this->render('data_reuters/show.html.twig', array(
            'data_reuter' => $data_reuter,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing data_reuter entity.
     *
     * @Route("/{id}/edit", name="data_reuters_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, data_reuters $data_reuter)
    {
        $deleteForm = $this->createDeleteForm($data_reuter);
        $editForm = $this->createForm('JournalBundle\Form\data_reutersType', $data_reuter);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('data_reuters_edit', array('id' => $data_reuter->getId()));
        }

        return $this->render('data_reuters/edit.html.twig', array(
            'data_reuter' => $data_reuter,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a data_reuter entity.
     *
     * @Route("/{id}", name="data_reuters_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, data_reuters $data_reuter)
    {
        $form = $this->createDeleteForm($data_reuter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($data_reuter);
            $em->flush();
        }

        return $this->redirectToRoute('data_reuters_index');
    }

    /**
     * Creates a form to delete a data_reuter entity.
     *
     * @param data_reuters $data_reuter The data_reuter entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(data_reuters $data_reuter)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('data_reuters_delete', array('id' => $data_reuter->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
