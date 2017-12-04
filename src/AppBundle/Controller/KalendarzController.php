<?php

namespace AppBundle\Controller;

use AppBundle\Entity\data_urlop;
use AppBundle\Entity\godz_przyj;
use AppBundle\Entity\lekarz_godz_przyj;
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
    private $entityManager;
    private $tokenStorage;
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
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array
     */
    private function setUrlopy(\DateTime $startDate, \DateTime $endDate){
        $eventArray=array();
        $urlops=$this->entityManager->getRepository(data_urlop::class)->getUserDataUrlops($this->getUser(),$startDate,$endDate);
        $tempDate=date_create_from_format('U',$startDate->getTimestamp());
        while($tempDate<=$endDate){
            $modify=true;
            foreach($urlops as $urlop){
                /**
                 * @var data_urlop $urlop
                 */
                if ($urlop->getData()->format('Y-m-d')==$tempDate->format('Y-m-d')){
                    $modify=false;
                    break;
                }
            }
            if ($modify) {
                $event=array(
                    'title'=>'Urlop - add',
                    'date'=>date_format($tempDate,'Y-m-d H:i:s'),
                    'id'=>$this->getUser()->getIdLekarz()->getId()
                );
                $eventArray[] = $event;
                $datas=$this->entityManager->getRepository(data_urlop::class)->getDataByData($startDate,$endDate);
                /**
                 * @var data_urlop $addDataUrlop
                 */
                $addDataUrlop=null;
                foreach ($datas as $data){
                    if ($tempDate->format('Y-m-d')==$data->getData()->format('Y-m-d')){
                        $addDataUrlop=$data;
                        break;
                    }
                }
                if (!$addDataUrlop){
                    $addDataUrlop=new data_urlop();
                    $addDataUrlop->setData(date_create_from_format('U',$tempDate->getTimestamp()));
                }
                $this->getUser()->getIdLekarz()->addUrlop($addDataUrlop);
                $this->entityManager->persist($this->getUser()->getIdLekarz());
            }
            $tempDate->modify('+1 day');
        }
        foreach($urlops as $urlop){
            /**
             * @var data_urlop $urlop
             */
            $event=array(
                'title'=>'Urlop - remove',
                'date'=>date_format($urlop->getData(),'Y-m-d H:i:s'),
            );
            $eventArray[] = $event;

            $this->getUser()->getIdLekarz()->removeUrlop($urlop);
            if ($urlop->getLekarze()->count()==0)
                $this->entityManager->remove($urlop);
            $this->entityManager->persist($this->getUser()->getIdLekarz());
        }


        return $eventArray;
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array
     */
    public function setGodzPrzyj(\DateTime $startDate, \DateTime $endDate)
    {
        $eventArray = array();
        $godzPrzyj = null;
        $godzPrzyjs = $this->entityManager->getRepository(godz_przyj::class)->getGodzPrzyjByData($startDate, $endDate);
        foreach ($godzPrzyjs as $godzPrzyjTmp) {
            /**
             * @var godz_przyj $godzPrzyjTmp
             */
            if ($godzPrzyjTmp->getGodzPoczatek()->format('H:i:s') == $startDate->format('H:i:s') && $godzPrzyjTmp->getGodzKoniec()->format('H:i:s') == $endDate->format('H:i:s')) {
                $godzPrzyj = $godzPrzyjTmp;
                break;
            }
        }
        $lekarzGodzPrzyj = null;
        if (!$godzPrzyj) {
            $godzPrzyj = new godz_przyj();
            $godzPrzyj->setGodzPoczatek($startDate);
            $godzPrzyj->setGodzKoniec($endDate);
        } else {
            $lekarzGodzPrzyj = $this->entityManager->getRepository(lekarz_godz_przyj::class)->getUserLekarzGodzPrzyjById($this->getUser(), $godzPrzyj->getId());
            if (count($lekarzGodzPrzyj))
                $lekarzGodzPrzyj = $lekarzGodzPrzyj[0];
            else
                $lekarzGodzPrzyj = null;
        }
        if (!$lekarzGodzPrzyj) {
            $lekarzGodzPrzyj = new lekarz_godz_przyj();
            $lekarzGodzPrzyj->setIdLekarz($this->getUser()->getIdLekarz());
            $lekarzGodzPrzyj->setIdGodzPrzyj($godzPrzyj);
        }
        $lekarzGodzPrzyj->setAktywna(true);
        $this->entityManager->persist($lekarzGodzPrzyj);
        return $eventArray;
    }

    /**
     * @Route("/set/data/{type}",name="set_kalendarz_data",options={"expose"=true})
     */
    public function setKalendarzData($type,Request $request){
        $startDate = date_create_from_format('U',$request->query->get('start'));
        $endDate = date_create_from_format('U',$request->query->get('end'));

        switch ($type){
            case 'urlop':
                $eventArray=$this->setUrlopy($startDate,$endDate);
                $this->entityManager->flush();
                break;
            case 'godz_przyj_add':
                $eventArray=$this->setGodzPrzyj($startDate,$endDate);
                $this->entityManager->flush();
                break;
            case 'godz_przyj_resize_move':
                $godzPrzyj=$this->entityManager->getRepository(lekarz_godz_przyj::class)->find($request->get('id'));
                if (count($godzPrzyj->getWizyty()))
                    $godzPrzyj->setAktywna(false);
                else
                    $this->entityManager->remove($godzPrzyj);
                $eventArray=$this->setGodzPrzyj($startDate,$endDate);
                $this->entityManager->flush();
                break;
        }

        $eventArray[] = array(
            'start'=>$startDate->format('Y-m-d H:i:s'),
            'end'=>$endDate->format('Y-m-d H:i:s')
        );
        return new JsonResponse($eventArray);

    }


    public function getFreeWizyta($startDate, $endDate, $idLekarz){
        $eventArray=array();
        $wizyty=$this->getDoctrine()->getRepository(wizyta::class)->getWizytaByIdLekarzDate($idLekarz,$startDate,$endDate);
        $godzPrzyj=$this->getDoctrine()->getRepository(lekarz_godz_przyj::class)->getLekarzGodzPrzyjByIdLekarz($idLekarz);

        foreach($godzPrzyj as $godz){
            /**
             * @var godz_przyj $godz
             */
            $show=true;
            foreach ($wizyty as $wizyta){
                /**
                 * @var wizyta $wizyta
                 */
                if ($wizyta->getIdLekarzGodzPrzyj()->getIdGodzPrzyj()->getId() == $godz->getId())
                    $show=false;
            }
            if ($show){
                $eventArray[] =array(
                    'start'=>$startDate." ".$godz->getGodzPoczatek()->format('H:i:s'),
                    'end'=>$endDate." ".$godz->getGodzKoniec()->format('H:i:s'),
                    'className'=>'godz_przyj_aktywna'
                );
            }
        }
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
                        'url'=>$this->generateUrl('wizyta_show',array('id'=>$wizyta->getId())),

                        );
                    $eventArray[]=$event;
                }
                break;
            case 'wizyta_lekarz':
                $idLekarz=$request->query->get('idLekarz');
                $eventArray=$this->getFreeWizyta($startDate,$endDate,$idLekarz);
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
                      'className'=>'urlop_day',
                    );
                    $eventArray[]=$event;
                }
                break;
            case 'godz_przyj':
                $godz_przyjs=$this->entityManager->getRepository(lekarz_godz_przyj::class)->getUserLekarzGodzPrzyj($this->getUser());
                foreach ($godz_przyjs as $godz){
                    /**
                     * @var lekarz_godz_przyj $godz
                     */
                    $nowStart=date_date_set($godz->getIdGodzPrzyj()->getGodzPoczatek(),getdate()['year'],getdate()['mon'],getdate()['mday']);
                    $nowEnd=date_date_set($godz->getIdGodzPrzyj()->getGodzKoniec(),getdate()['year'],getdate()['mon'],getdate()['mday']);
                    if ($godz->isAktywna())
                        $class='godz_przyj_aktywna';
                    else
                        $class='godz_przyj_nieaktywna';
                    $event=array(
                        'start'=>$nowStart->format('Y-m-d H:i:s'),
                        'end'=>$nowEnd->format('Y-m-d H:i:s'),
                        'url'=>$this->generateUrl('lekarz_godz_przyj_show',array('id'=>$godz->getId())),
                        'id'=>$godz->getId(),
                        'className'=>$class
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
