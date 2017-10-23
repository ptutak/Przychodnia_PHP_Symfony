<?php

namespace AppBundle\Controller;

use AppBundle\Entity\data_urlop;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Data_urlop controller.
 *
 * @Route("data_urlop")
 */
class data_urlopController extends Controller
{
    /**
     * Lists all data_urlop entities.
     *
     * @Route("/", name="data_urlop_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $data_urlops = $em->getRepository('AppBundle:data_urlop')->findAll();

        return $this->render('data_urlop/index.html.twig', array(
            'data_urlops' => $data_urlops,
        ));
    }

    /**
     * Creates a new data_urlop entity.
     *
     * @Route("/new", name="data_urlop_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $data_urlop = new Data_urlop();
        $form = $this->createForm('AppBundle\Form\data_urlopType', $data_urlop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($data_urlop);
            $em->flush();

            return $this->redirectToRoute('data_urlop_show', array('id' => $data_urlop->getId()));
        }

        return $this->render('data_urlop/new.html.twig', array(
            'data_urlop' => $data_urlop,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a data_urlop entity.
     *
     * @Route("/{id}", name="data_urlop_show")
     * @Method("GET")
     */
    public function showAction(data_urlop $data_urlop)
    {
        $deleteForm = $this->createDeleteForm($data_urlop);

        return $this->render('data_urlop/show.html.twig', array(
            'data_urlop' => $data_urlop,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing data_urlop entity.
     *
     * @Route("/{id}/edit", name="data_urlop_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, data_urlop $data_urlop)
    {
        $deleteForm = $this->createDeleteForm($data_urlop);
        $editForm = $this->createForm('AppBundle\Form\data_urlopType', $data_urlop);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('data_urlop_edit', array('id' => $data_urlop->getId()));
        }

        return $this->render('data_urlop/edit.html.twig', array(
            'data_urlop' => $data_urlop,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a data_urlop entity.
     *
     * @Route("/{id}", name="data_urlop_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, data_urlop $data_urlop)
    {
        $form = $this->createDeleteForm($data_urlop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($data_urlop);
            $em->flush();
        }

        return $this->redirectToRoute('data_urlop_index');
    }

    /**
     * Creates a form to delete a data_urlop entity.
     *
     * @param data_urlop $data_urlop The data_urlop entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(data_urlop $data_urlop)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('data_urlop_delete', array('id' => $data_urlop->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
