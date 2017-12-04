<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;


use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\ProfileController as BaseController;

/**
 * Controller managing the user profile.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends BaseController
{

    /**
     * @Route("/admin_profile",name="admin_profile")
     */
    public function admin_profileAction(Request $request){
        return $this->render(":Profile:admin.html.twig", array(

        ));
    }

    /**
     * @Route("/pacjent_profile",name="pacjent_profile")
     */
    public function pacjent_profileAction(Request $request){
        return $this->render(":Profile:pacjent.html.twig", array(

        ));
    }

    /**
     * @Route("/lekarz_profile",name="lekarz_profile")
     */
    public function lekarz_profileAction(Request $request){
        return $this->render(":Profile:lekarz.html.twig", array(
        ));
    }

    /**
     * @Route("/user_profile",name="user_profile",options={"expose"=true})
     */
    public function user_profileAction(){
        return $this->redirectToRoute('fos_user_profile_show');
    }

    /**
     * Show the user.
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
        ));
    }


}
