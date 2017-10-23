<?php

namespace AppBundle\Controller;

use AppBundle\Entity\specjalizacja;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Specjalizacja controller.
 *
 * @Route("specjalizacja")
 */
class specjalizacjaController extends Controller
{
    /**
     * Lists all specjalizacja entities.
     *
     * @Route("/", name="specjalizacja_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $specjalizacjas = $em->getRepository('AppBundle:specjalizacja')->findAll();

        return $this->render('specjalizacja/index.html.twig', array(
            'specjalizacjas' => $specjalizacjas,
        ));
    }

    /**
     * Creates a new specjalizacja entity.
     *
     * @Route("/new", name="specjalizacja_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $specjalizacja = new Specjalizacja();
        $form = $this->createForm('AppBundle\Form\specjalizacjaType', $specjalizacja);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($specjalizacja);
            $em->flush();

            return $this->redirectToRoute('specjalizacja_show', array('id' => $specjalizacja->getId()));
        }

        return $this->render('specjalizacja/new.html.twig', array(
            'specjalizacja' => $specjalizacja,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a specjalizacja entity.
     *
     * @Route("/{id}", name="specjalizacja_show")
     * @Method("GET")
     */
    public function showAction(specjalizacja $specjalizacja)
    {
        $deleteForm = $this->createDeleteForm($specjalizacja);

        return $this->render('specjalizacja/show.html.twig', array(
            'specjalizacja' => $specjalizacja,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing specjalizacja entity.
     *
     * @Route("/{id}/edit", name="specjalizacja_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, specjalizacja $specjalizacja)
    {
        $deleteForm = $this->createDeleteForm($specjalizacja);
        $editForm = $this->createForm('AppBundle\Form\specjalizacjaType', $specjalizacja);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('specjalizacja_edit', array('id' => $specjalizacja->getId()));
        }

        return $this->render('specjalizacja/edit.html.twig', array(
            'specjalizacja' => $specjalizacja,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a specjalizacja entity.
     *
     * @Route("/{id}", name="specjalizacja_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, specjalizacja $specjalizacja)
    {
        $form = $this->createDeleteForm($specjalizacja);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($specjalizacja);
            $em->flush();
        }

        return $this->redirectToRoute('specjalizacja_index');
    }

    /**
     * Creates a form to delete a specjalizacja entity.
     *
     * @param specjalizacja $specjalizacja The specjalizacja entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(specjalizacja $specjalizacja)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specjalizacja_delete', array('id' => $specjalizacja->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
