<?php

namespace AppBundle\Controller;

use AppBundle\Entity\lekarz_godz_przyj;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Lekarz_godz_przyj controller.
 *
 * @Route("lekarz_godz_przyj")
 */
class lekarz_godz_przyjController extends Controller
{
    /**
     * Lists all lekarz_godz_przyj entities.
     *
     * @Route("/", name="lekarz_godz_przyj_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lekarz_godz_przyjs = $em->getRepository('AppBundle:lekarz_godz_przyj')->findAll();

        return $this->render('lekarz_godz_przyj/index.html.twig', array(
            'lekarz_godz_przyjs' => $lekarz_godz_przyjs,
        ));
    }

    /**
     * Creates a new lekarz_godz_przyj entity.
     *
     * @Route("/new", name="lekarz_godz_przyj_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lekarz_godz_przyj = new Lekarz_godz_przyj();
        $form = $this->createForm('AppBundle\Form\lekarz_godz_przyjType', $lekarz_godz_przyj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lekarz_godz_przyj);
            $em->flush();

            return $this->redirectToRoute('lekarz_godz_przyj_show', array('id' => $lekarz_godz_przyj->getId()));
        }

        return $this->render('lekarz_godz_przyj/new.html.twig', array(
            'lekarz_godz_przyj' => $lekarz_godz_przyj,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a lekarz_godz_przyj entity.
     *
     * @Route("/{id}", name="lekarz_godz_przyj_show")
     * @Method("GET")
     */
    public function showAction(lekarz_godz_przyj $lekarz_godz_przyj)
    {
        $deleteForm = $this->createDeleteForm($lekarz_godz_przyj);

        return $this->render('lekarz_godz_przyj/show.html.twig', array(
            'lekarz_godz_przyj' => $lekarz_godz_przyj,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing lekarz_godz_przyj entity.
     *
     * @Route("/{id}/edit", name="lekarz_godz_przyj_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, lekarz_godz_przyj $lekarz_godz_przyj)
    {
        $deleteForm = $this->createDeleteForm($lekarz_godz_przyj);
        $editForm = $this->createForm('AppBundle\Form\lekarz_godz_przyjType', $lekarz_godz_przyj);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lekarz_godz_przyj_edit', array('id' => $lekarz_godz_przyj->getId()));
        }

        return $this->render('lekarz_godz_przyj/edit.html.twig', array(
            'lekarz_godz_przyj' => $lekarz_godz_przyj,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a lekarz_godz_przyj entity.
     *
     * @Route("/{id}", name="lekarz_godz_przyj_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, lekarz_godz_przyj $lekarz_godz_przyj)
    {
        $form = $this->createDeleteForm($lekarz_godz_przyj);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lekarz_godz_przyj);
            $em->flush();
        }

        return $this->redirectToRoute('lekarz_godz_przyj_index');
    }

    /**
     * Creates a form to delete a lekarz_godz_przyj entity.
     *
     * @param lekarz_godz_przyj $lekarz_godz_przyj The lekarz_godz_przyj entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(lekarz_godz_przyj $lekarz_godz_przyj)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lekarz_godz_przyj_delete', array('id' => $lekarz_godz_przyj->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
