<?php

namespace AppBundle\Controller;

use AppBundle\Entity\data_urlop;
use AppBundle\Entity\wizyta;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


/**
 * Class KalendarzController
 *
 * @Route("kalendarz")
 */
class KalendarzController extends Controller
{

    /**
     * KalendarzController constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenStorage $tokenStorage
     */
    public function __construct(EntityManagerInterface $entityManager,TokenStorage $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/set/data/{type}",name="set_kalendarz_data",options={"expose"=true})
     */
    public function setKalendarzData($type,Request $request){
        $startDate = date_create_from_format('U',$request->query->get('start'));
        $endDate = date_create_from_format('U',$request->query->get('end'));
        $eventArray=array();
        $eventArray[] = array(
            'start'=>$startDate->format('Y-m-d h:i:s'),
            'end'=>$endDate->format('Y-m-d h:i:s')
        );
        switch ($type){
            case 'urlop':
                $urlops=$this->entityManager->getRepository(data_urlop::class)->getUserDataUrlops($this->getUser(),$startDate,$endDate);
                foreach($urlops as $urlop){
                    /**
                     * @var data_urlop $urlop
                     */
                    $event=array(
                      'title'=>'Urlop - remove',
                        'date'=>date_format($urlop->getData(),'Y-m-d'),
                    );
                    $eventArray[] = $event;
                    $this->entityManager->remove($urlop);
                }
                $this->entityManager->flush();

                $tempDate=$startDate;
                while($tempDate<=$endDate){
                    $modify=true;
                    foreach($urlops as $urlop){
                        /**
                         * @var data_urlop $urlop
                         */
                        if ($urlop->getData()==$tempDate){
                            $modify=false;
                            break;
                        }

                    }
                    if ($modify) {
                        $event=array(
                            'title'=>'Urlop - add',
                            'date'=>date_format($tempDate,'Y-m-d'),
                            'id'=>$this->getUser()->getIdLekarz()->getId()
                        );
                        $eventArray[] = $event;
                        /**
                         * @var data_urlop $addDataUrlop
                         */
                        $addDataUrlop=new data_urlop();

                        $addDataUrlop->setData($tempDate);
                        $addDataUrlop->addLekarz($this->getUser()->getIdLekarz());
                        // $this->getUser()->getIdLekarz()->addUrlop($addDataUrlop);
                        $this->entityManager->persist($addDataUrlop);
                        //$this->entityManager->persist($this->getUser()->getIdLekarz());
                    }
                    $tempDate->modify('+1 day');

                }
//                $this->entityManager->flush();

                break;
        }

        return new JsonResponse($eventArray);

    }


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
            case 'urlop':
                $urlops=$this->entityManager->getRepository(data_urlop::class)->getUserUrlops($this->getUser());
                foreach ($urlops as $urlop){
                    /**
                     * @var data_urlop $urlop
                     */
                    $event=array(
                      'title'=>'Urlop',
                      'start'=>date_format($urlop->getData(),'Y-m-d'),
                        'end'=>date_format($urlop->getData(),'Y-m-d'),
                    );
                    $eventArray[]=$event;
                }
                break;
        }
        return new JsonResponse($eventArray);
    }

    /**
     * @Route("/",name="kalendarz_show")
     */
    public function showAction()
    {
        return $this->render(':Kalendarz:show.html.twig', array());
    }


}
