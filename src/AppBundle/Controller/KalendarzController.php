<?php

namespace AppBundle\Controller;

use AppBundle\Entity\data_urlop;
use AppBundle\Entity\godz_przyj;
use AppBundle\Entity\lekarz;
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
        $wizyts=$this->entityManager->getRepository(wizyta::class)->getWizytaByIdLekarzDate($this->getUser()->getIdLekarz(),$startDate,$endDate);
        $tempDate=date_create_from_format('U',$startDate->getTimestamp());
        while($tempDate<=$endDate){
            if ($tempDate->format('D')=='Sat' || $tempDate->format('D')=='Sun'){
                $tempDate->modify('+1 day');
                continue;
            }
            $add=true;
            foreach($urlops as $urlop){
                /**
                 * @var data_urlop $urlop
                 */
                if ($urlop->getData()->format('Y-m-d')==$tempDate->format('Y-m-d')){
                    $add=false;
                    break;
                }
            }
            if ($add) {
                foreach($wizyts as $wizyta){
                    /**
                     * @var wizyta $wizyta
                     */
                    if ($wizyta->getData()->format('Y-m-d')==$tempDate->format('Y-m-d')){
                        $add=false;
                        break;
                    }

                }
                if ($add){
                    $event=array(
                        'title'=>'Urlop - add',
                        'date'=>date_format($tempDate,'Y-m-d H:i:s'),
                        'id'=>$this->getUser()->getIdLekarz()->getId()
                    );
                    $eventArray[] = $event;
                    $datas=$this->entityManager->getRepository(data_urlop::class)->getDataUrlopByData($startDate,$endDate);
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
            case 'wizyta_new_select':
                $wizyta=new wizyta();
                $wizyta->setIndeks(chr(rand(ord('A'),ord('Z'))).date('U'));
                $wizyta->setData($startDate);
                $wizyta->setIdLekarzGodzPrzyj($this->entityManager->getRepository(lekarz_godz_przyj::class)->find($request->query->get('idLekarzGodzPrzyj')));
                $wizyta->setIdPacjent($this->getUser()->getIdPacjent());
                $this->entityManager->persist($wizyta);
                $this->entityManager->flush();
                break;
        }

        $eventArray[] = array(
            'start'=>$startDate->format('Y-m-d H:i:s'),
            'end'=>$endDate->format('Y-m-d H:i:s')
        );
        return new JsonResponse($eventArray);

    }


    public function getFreeWizytas($startDate, $endDate, $idLekarz){
        $eventArray=[];
        $godzPrzyj=$this->getDoctrine()->getRepository(lekarz_godz_przyj::class)->getActiveLekarzGodzPrzyjByIdLekarz($idLekarz);
        $wizyty = $this->getDoctrine()->getRepository(wizyta::class)->getWizytaByIdLekarzDate($idLekarz,$startDate,$endDate);
        $urlopy = $this->getDoctrine()->getRepository(data_urlop::class)->getDataUrlopByIdLekarz($idLekarz,$startDate,$endDate);
        $tempDate=date_create_from_format('U',$startDate->getTimestamp());
        while($tempDate<=$endDate){
            if ($tempDate->format('D')=='Sat' || $tempDate->format('D')=='Sun'){
                $tempDate->modify('+1 day');
                continue;
            }
            $show=true;
            foreach ($urlopy as $urlop){
                /**
                 * @var data_urlop $urlop
                 */
                if ($urlop->getData()->format('Y-m-d')==$tempDate->format('Y-m-d')){
                    $show=false;
                    break;
                }
            }
            if ($show) {
                foreach ($godzPrzyj as $godz) {
                    $show = true;
                    /**
                     * @var lekarz_godz_przyj $godz
                     */
                    foreach ($wizyty as $wizyta) {
                        /**
                         * @var wizyta $wizyta
                         */
                        if ($wizyta->getIdLekarzGodzPrzyj() === $godz && $wizyta->getData()->format('Y-m-d') == $tempDate->format('Y-m-d')) {
                            $show = false;
                            break;
                        }
                    }
                    if ($show) {
                        $eventArray[] = array(
                            'start' => $tempDate->format('Y-m-d') . " " . $godz->getIdGodzPrzyj()->getGodzPoczatek()->format('H:i:s'),
                            'end' => $tempDate->format('Y-m-d') . " " . $godz->getIdGodzPrzyj()->getGodzKoniec()->format('H:i:s'),
                            'idLekarzGodzPrzyj'=>$godz->getId(),
                            'className' => 'godz_przyj_aktywna'
                        );
                    }
                }
            }
            $tempDate->modify('+1 day');
        }
        return $eventArray;
    }

    /**
     * @Route("/get/data/{type}",name="get_kalendarz_data", options={"expose"=true})
     *
     */
    public function getKalendarzData($type, Request $request)
    {
        $startDate = date_create_from_format('U',$request->query->get('start'));
        $endDate = date_create_from_format('U',$request->query->get('end'));
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
                        'start'=>$wizyta->getData()->format('Y-m-d ').$wizyta->getIdLekarzGodzPrzyj()->getIdGodzPrzyj()->getGodzPoczatek()->format('H:i:m'),
                        'end'=>$wizyta->getData()->format('Y-m-d ').$wizyta->getIdLekarzGodzPrzyj()->getIdGodzPrzyj()->getGodzKoniec()->format('H:i:m'),
                        'url'=>$this->generateUrl('wizyta_show',array('id'=>$wizyta->getId())),
                        'className'=>'wizyta_list'
                        );
                    $eventArray[]=$event;
                }
                break;
            case 'wolna_wizyta_lekarz':
                $idLekarz=$request->query->get('idLekarz');
                $eventArray=$this->getFreeWizytas($startDate,$endDate,$idLekarz);
                break;
            case 'profile':
                $wizyty=$this->getDoctrine()->getRepository(wizyta::class)->getWizytaByUserDate($this->getUser(),$startDate,$endDate);
                $urlopy=null;
                if ($this->getUser()->getIdLekarz()!=null)
                    $urlopy=$this->entityManager->getRepository(data_urlop::class)->getUserDataUrlops($this->getUser(),$startDate,$endDate);
                foreach ($wizyty as $wizyta){
                    /**
                     * @var wizyta $wizyta
                     */
                    if ($wizyta->getIdLekarzGodzPrzyj()->getIdLekarz()===$this->getUser()->getIdLekarz())
                        $eventArray[]=array(
                            'title'=>'Wizyta - Indeks:'.$wizyta->getIndeks(),
                            'start'=>$wizyta->getData()->format('Y-m-d ').$wizyta->getIdLekarzGodzPrzyj()->getIdGodzPrzyj()->getGodzPoczatek()->format('H:i:m'),
                            'end'=>$wizyta->getData()->format('Y-m-d ').$wizyta->getIdLekarzGodzPrzyj()->getIdGodzPrzyj()->getGodzKoniec()->format('H:i:m'),
                            'url'=>$this->generateUrl('wizyta_show',array('id'=>$wizyta->getId())),
                            'className'=>'wizyta_lekarz'
                        );
                    else
                        $eventArray[] = array(
                            'title'=>'Umówiona wizyta:'.$wizyta->getIdLekarzGodzPrzyj()->getIdLekarz()->__toString(),
                            'start'=>$wizyta->getData()->format('Y-m-d ').$wizyta->getIdLekarzGodzPrzyj()->getIdGodzPrzyj()->getGodzPoczatek()->format('H:i:m'),
                            'end'=>$wizyta->getData()->format('Y-m-d ').$wizyta->getIdLekarzGodzPrzyj()->getIdGodzPrzyj()->getGodzKoniec()->format('H:i:m'),
                            'url'=>$this->generateUrl('wizyta_show',array('id'=>$wizyta->getId())),
                            'className'=>'wizyta_pacjent'
                        );
                }
                foreach ($urlopy as $urlop){
                    /**
                     * @var data_urlop $urlop
                     */
                    $eventArray[] = array(
                        'title'=>'Urlop',
                        'start'=>date_format($urlop->getData(),'Y-m-d'),
                        'end'=>date_format($urlop->getData(),'Y-m-d'),
                        'className'=>'urlop_day',
                    );
                }
                break;
            case 'urlop':
                $urlops=$this->entityManager->getRepository(data_urlop::class)->getUserDataUrlops($this->getUser(),$startDate,$endDate);
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
