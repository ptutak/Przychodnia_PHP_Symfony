<?php

namespace AppBundle\Controller;

use AppBundle\Entity\pacjent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pacjent controller.
 *
 * @Route("pacjent")
 */
class pacjentController extends Controller
{
    /**
     * Lists all pacjent entities.
     *
     * @Route("/", name="pacjent_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pacjents = $em->getRepository('AppBundle:pacjent')->findAll();

        return $this->render('pacjent/index.html.twig', array(
            'pacjents' => $pacjents,
        ));
    }

    /**
     * Creates a new pacjent entity.
     *
     * @Route("/new", name="pacjent_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pacjent = new Pacjent();
        $form = $this->createForm('AppBundle\Form\pacjentType', $pacjent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pacjent);
            $em->flush();

            return $this->redirectToRoute('pacjent_show', array('id' => $pacjent->getId()));
        }

        return $this->render('pacjent/new.html.twig', array(
            'pacjent' => $pacjent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pacjent entity.
     *
     * @Route("/{id}", name="pacjent_show")
     * @Method("GET")
     */
    public function showAction(pacjent $pacjent)
    {
        $deleteForm = $this->createDeleteForm($pacjent);

        return $this->render('pacjent/show.html.twig', array(
            'pacjent' => $pacjent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pacjent entity.
     *
     * @Route("/{id}/edit", name="pacjent_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, pacjent $pacjent)
    {
        $deleteForm = $this->createDeleteForm($pacjent);
        $editForm = $this->createForm('AppBundle\Form\pacjentType', $pacjent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pacjent_edit', array('id' => $pacjent->getId()));
        }

        return $this->render('pacjent/edit.html.twig', array(
            'pacjent' => $pacjent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pacjent entity.
     *
     * @Route("/{id}", name="pacjent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, pacjent $pacjent)
    {
        $form = $this->createDeleteForm($pacjent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pacjent);
            $em->flush();
        }

        return $this->redirectToRoute('pacjent_index');
    }

    /**
     * Creates a form to delete a pacjent entity.
     *
     * @param pacjent $pacjent The pacjent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(pacjent $pacjent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pacjent_delete', array('id' => $pacjent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
