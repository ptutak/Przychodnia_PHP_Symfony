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
     * @var bool
     */
    private $showPlan=false;

    /**
     * @return bool
     */
    public function isShowPlan()
    {
        return $this->showPlan;
    }

    /**
     * @param bool $showPlan
     */
    public function setShowPlan($showPlan)
    {
        $this->showPlan = $showPlan;
    }


    /**
     * @Route("/profile/get_plan", name="get_plan_profile")
     * @Method({"POST","GET"})
     */
    public function getPlanAction(Request $request){
        var_dump($request->query->all());
        return $this->render('dump.html.twig');
        if ($this->isShowPlan()){
            $this->setShowPlan(false);
            $startDate=$request->query('start');
            $endDate=$request->query('end');

            return $this->render(':Profile:get_plan.html.twig'); // Zwróć tablicę z tym co trzeba zwrócić
        }
        else{
            return null;
        }
    }

    /**
     * @Route("/admin",name="admin")
     */
    public function adminAction(Request $request){
        return $this->render(":Profile:admin.html.twig", array(

        ));
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
        $this->setShowPlan(true);
        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
        ));
    }


}
