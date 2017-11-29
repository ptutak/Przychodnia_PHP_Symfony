<?php

namespace AppBundle\Controller;

use AppBundle\Entity\godz_przyj;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Godz_przyj controller.
 *
 * @Route("godz_przyj")
 */
class godz_przyjController extends Controller
{
    /**
     * Lists all godz_przyj entities.
     *
     * @Route("/", name="godz_przyj_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $godz_przyjs = $em->getRepository('AppBundle:godz_przyj')->findAll();

        return $this->render('godz_przyj/index.html.twig', array(
            'godz_przyjs' => $godz_przyjs,
        ));
    }

    /**
     * Creates a new godz_przyj entity.
     *
     * @Route("/new", name="godz_przyj_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $godz_przyj = new Godz_przyj();
        $form = $this->createForm('AppBundle\Form\godz_przyjType', $godz_przyj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($godz_przyj);
            $em->flush();

            return $this->redirectToRoute('godz_przyj_show', array('id' => $godz_przyj->getId()));
        }

        return $this->render('godz_przyj/new.html.twig', array(
            'godz_przyj' => $godz_przyj,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a godz_przyj entity.
     *
     * @Route("/{id}", name="godz_przyj_show")
     * @Method("GET")
     */
    public function showAction(godz_przyj $godz_przyj)
    {
        $deleteForm = $this->createDeleteForm($godz_przyj);

        return $this->render('godz_przyj/show.html.twig', array(
            'godz_przyj' => $godz_przyj,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing godz_przyj entity.
     *
     * @Route("/{id}/edit", name="godz_przyj_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, godz_przyj $godz_przyj)
    {
        $deleteForm = $this->createDeleteForm($godz_przyj);
        $editForm = $this->createForm('AppBundle\Form\godz_przyjType', $godz_przyj);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('godz_przyj_edit', array('id' => $godz_przyj->getId()));
        }

        return $this->render('godz_przyj/edit.html.twig', array(
            'godz_przyj' => $godz_przyj,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a godz_przyj entity.
     *
     * @Route("/{id}", name="godz_przyj_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, godz_przyj $godz_przyj)
    {
        $form = $this->createDeleteForm($godz_przyj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($godz_przyj);
            $em->flush();
        }

        return $this->redirectToRoute('godz_przyj_index');
    }

    /**
     * Creates a form to delete a godz_przyj entity.
     *
     * @param godz_przyj $godz_przyj The godz_przyj entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(godz_przyj $godz_przyj)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('godz_przyj_delete', array('id' => $godz_przyj->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
