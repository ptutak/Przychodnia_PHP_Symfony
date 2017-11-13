<?php

namespace AppBundle\Controller;

use AppBundle\Entity\wizyta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class KalendarzController
 *
 * @Route("kalendarz")
 */
class KalendarzController extends Controller
{


    /**
     * @Route("/get/data/{type}",name="get_kalendarz_data", options={"expose"=true})
     *
     */
    public function getKalendarzData($type, Request $request)
    {
        $startDate = date_format(date_create_from_format('U',$request->query->get('start')),'Y-m-d');
        $endDate = date_format(date_create_from_format('U',$request->query->get('end')),'Y-m-d');
        $eventArray=array();
        switch($type){
            case 'wizyta':
                $wizyty=$this->getDoctrine()->getRepository(wizyta::class)->getEventsByDate($startDate,$endDate);
                foreach ( $wizyty as $wizyta){
                    /**
                     * @var wizyta $wizyta
                     */
                    $event=array(
                        'title'=>'Indeks: '.$wizyta->getIndeks(),
                        'start'=>date_format($wizyta->getData(),'Y-m-d'),
                        'end'=>date_format($wizyta->getData(),'Y-m-d'),
                        'url'=>$this->generateUrl('wizyta_show',array('id'=>$wizyta->getId()))
                        );
                    $eventArray[]=$event;
                }
                break;
            case 'profile':

                break;
        }
        return new JsonResponse($eventArray);
    }

    /**
     * @Route("/get_plan", name="get_plan_kalendarz")
     * @Method({"POST","GET"})
     */
    public function getPlanAction(Request $request)
    {
        $startDate = $request->query('start');
        $endDate = $request->query('end');
        var_dump($request->query->all());
        return $this->render('::dump.html.twig');
    }

    /**
     * @Route("/",name="kalendarz_show")
     */
    public function showAction()
    {
        return $this->render(':Kalendarz:show.html.twig', array());
    }

}
