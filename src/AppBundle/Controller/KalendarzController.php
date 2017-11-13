<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class KalendarzController
 *
 * @Route("kalendarz")
 */
class KalendarzController extends Controller
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
     * @Route("/get_plan", name="get_plan_kalendarz")
     * @Method({"POST","GET"})
     */
    public function getPlanAction(Request $request){
        var_dump($request->query->all());
        return $this->render('::dump.html.twig');
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
     * @Route("/",name="kalendarz_show")
     */
    public function showAction()
    {
        return $this->render(':Kalendarz:show.html.twig', array(
        ));
    }

}
