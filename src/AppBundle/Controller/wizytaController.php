<?php

namespace AppBundle\Controller;

use AppBundle\Entity\wizyta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Wizytum controller.
 *
 * @Route("wizyta")
 */
class wizytaController extends Controller
{

    /**
     * Lists all wizytum entities.
     *
     * @Route("/", name="wizyta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $wizytas = $em->getRepository('AppBundle:wizyta')->findAll();

        return $this->render('wizyta/index.html.twig', array(
            'wizytas' => $wizytas,
        ));
    }

    /**
     * Creates a new wizytum entity.
     *
     * @Route("/new", name="wizyta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $wizytum = new Wizyta();
        $form = $this->createForm('AppBundle\Form\wizytaType', $wizytum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wizytum);
            $em->flush();

            return $this->redirectToRoute('wizyta_show', array('id' => $wizytum->getId()));
        }

        return $this->render('wizyta/new.html.twig', array(
            'wizytum' => $wizytum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new wizytum entity.
     *
     * @Route("/new_regular", name="wizyta_new_regular")
     * @Method({"GET", "POST"})
     */
    public function new_regularAction(Request $request)
    {
        $wizytum = new Wizyta();
        $form = $this->createForm('AppBundle\Form\wizytaType', $wizytum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wizytum);
            $em->flush();

            return $this->redirectToRoute('wizyta_show', array('id' => $wizytum->getId()));
        }

        return $this->render('wizyta/new_regular.html.twig', array(
            'wizytum' => $wizytum,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a wizytum entity.
     *
     * @Route("/{id}", name="wizyta_show")
     * @Method("GET")
     */
    public function showAction(wizyta $wizytum)
    {
        $deleteForm = $this->createDeleteForm($wizytum);

        return $this->render('wizyta/show.html.twig', array(
            'wizytum' => $wizytum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a wizytum entity.
     *
     * @Route("/{id}/show_regular", name="wizyta_show_regular",options={"expose"=true})
     * @Method("GET")
     */
    public function show_regularAction(wizyta $wizytum)
    {
        $deleteForm = $this->createDeleteForm($wizytum);

        return $this->render('wizyta/show-regular.html.twig', array(
            'wizytum' => $wizytum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing wizytum entity.
     *
     * @Route("/{id}/edit", name="wizyta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, wizyta $wizytum)
    {
        $deleteForm = $this->createDeleteForm($wizytum);
        $editForm = $this->createForm('AppBundle\Form\wizytaType', $wizytum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wizyta_edit', array('id' => $wizytum->getId()));
        }

        return $this->render('wizyta/edit.html.twig', array(
            'wizytum' => $wizytum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a wizytum entity.
     *
     * @Route("/{id}", name="wizyta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, wizyta $wizytum)
    {
        $form = $this->createDeleteForm($wizytum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($wizytum);
            $em->flush();
        }

        return $this->redirectToRoute('wizyta_index');
    }

    /**
     * Creates a form to delete a wizytum entity.
     *
     * @param wizyta $wizytum The wizytum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(wizyta $wizytum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('wizyta_delete', array('id' => $wizytum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
