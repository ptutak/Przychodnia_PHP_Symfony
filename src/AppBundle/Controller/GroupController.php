<?php
/**
 * Created by PhpStorm.
 * User: PiotrTutak
 * Date: 30.10.2017
 * Time: 19:56
 */

namespace AppBundle\Controller;
use FOS\UserBundle\Controller\GroupController as BaseController;
use FOS\UserBundle\Event\FilterGroupResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseGroupEvent;
use FOS\UserBundle\Event\GroupEvent;
use FOS\UserBundle\FOSUserEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class GroupController extends BaseController
{

    public function getExistingRoles()
    {
        $roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');
        $roles = array_keys($roleHierarchy);
        $theRoles=[];
        foreach ($roles as $role) {
            $theRoles[$role] = $role;
        }
        return $theRoles;
    }

    /**
     * @Route("/group/index",name="group_index")
     */
    public function indexAction(Request $request){
        return $this->render(":Group:index.html.twig",array(

        ));
    }

    /**
     * Edit one group, show the edit form.
     *
     * @param Request $request
     * @param string  $groupName
     *
     * @return Response
     */
    public function editAction(Request $request, $groupName)
    {
        $group = $this->findGroupBy('name', $groupName);

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseGroupEvent($group, $request);
        $dispatcher->dispatch(FOSUserEvents::GROUP_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /**
         * @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface
         */
        $formFactory = $this->get('fos_user.group.form.factory');

        $form = $formFactory->createForm();
        $form->add('roles', ChoiceType::class, array(
            'choices' => $this->getExistingRoles(),
            'data' => $group->getRoles(),
            'label' => 'Roles',
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
        ));

        $form->setData($group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $groupManager \FOS\UserBundle\Model\GroupManagerInterface */
            $groupManager = $this->get('fos_user.group_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::GROUP_EDIT_SUCCESS, $event);

            $groupManager->updateGroup($group);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_group_show', array('groupName' => $group->getName()));
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::GROUP_EDIT_COMPLETED, new FilterGroupResponseEvent($group, $request, $response));

            return $response;
        }

        return $this->render('@FOSUser/Group/edit.html.twig', array(
            'form' => $form->createView(),
            'group_name' => $group->getName(),
        ));
    }

    /**
     * Show the new form.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function newAction(Request $request)
    {
        /** @var $groupManager \FOS\UserBundle\Model\GroupManagerInterface */
        $groupManager = $this->get('fos_user.group_manager');
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.group.form.factory');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $group = $groupManager->createGroup('');

        $dispatcher->dispatch(FOSUserEvents::GROUP_CREATE_INITIALIZE, new GroupEvent($group, $request));

        $form = $formFactory->createForm();
        $form->add('roles', ChoiceType::class, array(
            'choices' => $this->getExistingRoles(),
            'data' => $group->getRoles(),
            'label' => 'Roles',
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
        ));
        $form->setData($group);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::GROUP_CREATE_SUCCESS, $event);

            $groupManager->updateGroup($group);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_group_show', array('groupName' => $group->getName()));
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::GROUP_CREATE_COMPLETED, new FilterGroupResponseEvent($group, $request, $response));

            return $response;
        }

        return $this->render('@FOSUser/Group/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}