<?php

namespace AppBundle\Controller;

use AppBundle\Entity\lekarz;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Lekarz controller.
 *
 * @Route("lekarz")
 */
class lekarzController extends Controller
{
    /**
     * Lists all lekarz entities.
     *
     * @Route("/", name="lekarz_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lekarzs = $em->getRepository('AppBundle:lekarz')->findAll();
        return $this->render('lekarz/index.html.twig', array(
            'lekarzs' => $lekarzs,
        ));
    }

    /**
     * @Route("/list",name="get_lekarz_list",options={"expose"=true})
     * @Method("GET")
     * @return JsonResponse
     */
    public function listAction(){
        $em=$this->getDoctrine()->getManager();

        $lekarze=$em->getRepository(lekarz::class)->findAll();
        $lekarzeArray=[];

        foreach($lekarze as $lekarz){
            $lekarzeArray[] = array(
                'id'=>$lekarz->getId(),
                'name'=>$lekarz->__toString(),
            );
        }
        return new JsonResponse($lekarzeArray);
    }


    /**
     * Creates a new lekarz entity.
     *
     * @Route("/new", name="lekarz_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lekarz = new Lekarz();
        $form = $this->createForm('AppBundle\Form\lekarzType', $lekarz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lekarz);
            $em->flush();

            return $this->redirectToRoute('lekarz_show', array('id' => $lekarz->getId()));
        }

        return $this->render('lekarz/new.html.twig', array(
            'lekarz' => $lekarz,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a lekarz entity.
     *
     * @Route("/{id}", name="lekarz_show")
     * @Method("GET")
     */
    public function showAction(lekarz $lekarz)
    {
        $deleteForm = $this->createDeleteForm($lekarz);

        return $this->render('lekarz/show.html.twig', array(
            'lekarz' => $lekarz,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing lekarz entity.
     *
     * @Route("/{id}/edit", name="lekarz_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, lekarz $lekarz)
    {
        $deleteForm = $this->createDeleteForm($lekarz);
        $editForm = $this->createForm('AppBundle\Form\lekarzType', $lekarz);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lekarz_edit', array('id' => $lekarz->getId()));
        }

        return $this->render('lekarz/edit.html.twig', array(
            'lekarz' => $lekarz,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * @Route("/{id}/lekarz_profile_edit",name="lekarz_profile_edit")
     * @Method({"GET", "POST"})
     */
    public function lekarz_profile_editAction(Request $request,lekarz $lekarz){

        $deleteForm = $this->createDeleteForm($lekarz);
        $editForm = $this->createForm('AppBundle\Form\lekarzType', $lekarz);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_profile');
        }

        return $this->render(':Profile:lekarz-edit.html.twig', array(
            'lekarz' => $lekarz,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'user'=>$this->getUser()
        ));
    }

    /**
     * @Route("/{id}/lekarz_profile_show",name="lekarz_profile_show")
     * @Method("GET")
     */
    public function lekarz_profile_showAction(Request $request, lekarz $lekarz){

        $deleteForm = $this->createDeleteForm($lekarz);

        return $this->render(':Profile:lekarz-show.html.twig', array(
            'lekarz' => $lekarz,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a lekarz entity.
     *
     * @Route("/{id}", name="lekarz_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, lekarz $lekarz)
    {
        $form = $this->createDeleteForm($lekarz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lekarz);
            $em->flush();
        }

        return $this->redirectToRoute('lekarz_index');
    }

    /**
     * Creates a form to delete a lekarz entity.
     *
     * @param lekarz $lekarz The lekarz entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(lekarz $lekarz)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lekarz_delete', array('id' => $lekarz->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
