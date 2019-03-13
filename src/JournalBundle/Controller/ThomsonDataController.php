<?php

namespace JournalBundle\Controller;

use JournalBundle\Entity\ThomsonData;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Thomsondatum controller.
 *
 * @Route("thomsondata")
 */
class ThomsonDataController extends Controller
{
    /**
     * Lists all thomsonDatum entities.
     *
     * @Route("/thomson", name="thomsondata_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $thomsonDatas = $em->getRepository('JournalBundle:ThomsonData')->findAll();

        return $this->render('thomsondata/index.html.twig', array(
            'thomsonDatas' => $thomsonDatas,
        ));
    }

    /**
     * Creates a new thomsonDatum entity.
     *
     * @Route("/new", name="thomsondata_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $thomsonDatum = new Thomsondatum();
        $form = $this->createForm('JournalBundle\Form\ThomsonDataType', $thomsonDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($thomsonDatum);
            $em->flush();

            return $this->redirectToRoute('thomsondata_show', array('id' => $thomsonDatum->getId()));
        }

        return $this->render('thomsondata/new.html.twig', array(
            'thomsonDatum' => $thomsonDatum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a thomsonDatum entity.
     *
     * @Route("/{id}", name="thomsondata_show")
     * @Method("GET")
     */
    public function showAction(ThomsonData $thomsonDatum)
    {
        $deleteForm = $this->createDeleteForm($thomsonDatum);

        return $this->render('thomsondata/show.html.twig', array(
            'thomsonDatum' => $thomsonDatum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing thomsonDatum entity.
     *
     * @Route("/{id}/edit", name="thomsondata_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ThomsonData $thomsonDatum)
    {
        $deleteForm = $this->createDeleteForm($thomsonDatum);
        $editForm = $this->createForm('JournalBundle\Form\ThomsonDataType', $thomsonDatum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('thomsondata_edit', array('id' => $thomsonDatum->getId()));
        }

        return $this->render('thomsondata/edit.html.twig', array(
            'thomsonDatum' => $thomsonDatum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a thomsonDatum entity.
     *
     * @Route("/{id}", name="thomsondata_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ThomsonData $thomsonDatum)
    {
        $form = $this->createDeleteForm($thomsonDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($thomsonDatum);
            $em->flush();
        }

        return $this->redirectToRoute('thomsondata_index');
    }

    /**
     * Creates a form to delete a thomsonDatum entity.
     *
     * @param ThomsonData $thomsonDatum The thomsonDatum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ThomsonData $thomsonDatum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('thomsondata_delete', array('id' => $thomsonDatum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
