<?php

namespace AppBundle\Controller;

use AppBundle\Entity\leki;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Leki controller.
 *
 * @Route("leki")
 */
class lekiController extends Controller
{
    /**
     * Lists all leki entities.
     *
     * @Route("/", name="leki_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lekis = $em->getRepository('AppBundle:leki')->findAll();

        return $this->render('leki/index.html.twig', array(
            'lekis' => $lekis,
        ));
    }

    /**
     * Creates a new leki entity.
     *
     * @Route("/new", name="leki_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $leki = new Leki();
        $form = $this->createForm('AppBundle\Form\lekiType', $leki);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($leki);
            $em->flush();

            return $this->redirectToRoute('leki_show', array('id' => $leki->getId()));
        }

        return $this->render('leki/new.html.twig', array(
            'leki' => $leki,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a leki entity.
     *
     * @Route("/{id}", name="leki_show")
     * @Method("GET")
     */
    public function showAction(leki $leki)
    {
        $deleteForm = $this->createDeleteForm($leki);

        return $this->render('leki/show.html.twig', array(
            'leki' => $leki,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing leki entity.
     *
     * @Route("/{id}/edit", name="leki_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, leki $leki)
    {
        $deleteForm = $this->createDeleteForm($leki);
        $editForm = $this->createForm('AppBundle\Form\lekiType', $leki);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('leki_edit', array('id' => $leki->getId()));
        }

        return $this->render('leki/edit.html.twig', array(
            'leki' => $leki,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a leki entity.
     *
     * @Route("/{id}", name="leki_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, leki $leki)
    {
        $form = $this->createDeleteForm($leki);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($leki);
            $em->flush();
        }

        return $this->redirectToRoute('leki_index');
    }

    /**
     * Creates a form to delete a leki entity.
     *
     * @param leki $leki The leki entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(leki $leki)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('leki_delete', array('id' => $leki->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
