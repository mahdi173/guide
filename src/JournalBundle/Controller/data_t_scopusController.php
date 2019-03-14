<?php

namespace JournalBundle\Controller;

use JournalBundle\Entity\data_t_scopus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Data_t_scopus controller.
 *
 * @Route("data_t_scopus")
 */
class data_t_scopusController extends Controller
{

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/", name="data_t_scopus_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $data_t_scopuses = $em->getRepository('JournalBundle:data_t_scopus')->findAll();

        return $this->render('data_t_scopus/index.html.twig', array(
            'data_t_scopuses' => $data_t_scopuses,
        ));
    }

    /**
     * Creates a new data_t_scopus entity.
     *
     * @Route("/new", name="data_t_scopus_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $data_t_scopus = new Data_t_scopus();
        $form = $this->createForm('JournalBundle\Form\data_t_scopusType', $data_t_scopus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($data_t_scopus);
            $em->flush();

            return $this->redirectToRoute('data_t_scopus_show', array('id' => $data_t_scopus->getId()));
        }
        return $this->render('data_t_scopus/new.html.twig', array(
            'data_t_scopus' => $data_t_scopus,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a data_t_scopus entity.
     *
     * @Route("/{eISSN}", name="data_t_scopus_showByIssn")
     * @Method("GET")
     */
    public function showActionByIssn($eISSN)
    {

        $data_t_scopus=$this->findInScopus($eISSN);
        if($data_t_scopus==null) {echo "huuuuumm"; return $this->render('base.html.twig');}
        else
        return $this->render('data_t_scopus/scopus.html.twig', array(
            'data_t_scopus' => $data_t_scopus,
        ));
    }

    public function findInScopus($value)
    {

        $em = $this->getDoctrine()->getManager();
        $data_t_scopus = $em->getRepository('JournalBundle:data_t_scopus')->findOneBy(array('eISSN' => $value));
        echo "je suis 0";
        if ($data_t_scopus == null) {
            echo "je suis 1";
            $data_t_scopus = $em->getRepository('JournalBundle:data_t_scopus')->findOneBy(array('printISSN' => $value));
            if ($data_t_scopus == null){ $data_t_scopus = $em->getRepository('JournalBundle:data_t_scopus')->findOneBy(array('title' => $value));
            if ($data_t_scopus == null) {
                $data_t_scopus = $em->getRepository('JournalBundle:data_t_scopus')->findBy(array('title' => $value));
            }
            }
        }
        return $data_t_scopus;
    }
    /**
     * Finds and displays a data_t_scopus entity.
     *
     * @Route("/{id}", name="data_t_scopus_show")
     * @Method("GET")
     */
    public function showAction(data_t_scopus $data_t_scopus)
    {
        $deleteForm = $this->createDeleteForm($data_t_scopus);
        return $this->render('data_t_scopus/show.html.twig', array(
            'data_t_scopus' => $data_t_scopus,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing data_t_scopus entity.
     *
     * @Route("/{id}/edit", name="data_t_scopus_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, data_t_scopus $data_t_scopus)
    {
        $deleteForm = $this->createDeleteForm($data_t_scopus);
        $editForm = $this->createForm('JournalBundle\Form\data_t_scopusType', $data_t_scopus);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('data_t_scopus_edit', array('id' => $data_t_scopus->getId()));
        }

        return $this->render('data_t_scopus/edit.html.twig', array(
            'data_t_scopus' => $data_t_scopus,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a data_t_scopus entity.
     *
     * @Route("/{id}", name="data_t_scopus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, data_t_scopus $data_t_scopus)
    {
        $form = $this->createDeleteForm($data_t_scopus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($data_t_scopus);
            $em->flush();
        }

        return $this->redirectToRoute('data_t_scopus_index');
    }

    /**
     * Creates a form to delete a data_t_scopus entity.
     *
     * @param data_t_scopus $data_t_scopus The data_t_scopus entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(data_t_scopus $data_t_scopus)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('data_t_scopus_delete', array('id' => $data_t_scopus->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
