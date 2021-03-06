<?php

namespace AppBundle\Repository;
use AppBundle\Entity\lekarz;
use AppBundle\Entity\lekarz_godz_przyj;
use AppBundle\Entity\wizyta;

/**
 * wizytaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class wizytaRepository extends \Doctrine\ORM\EntityRepository
{
    public function getEventsByDate($start, $end){
        $q=$this->getEntityManager()->createQuery('
        SELECT wizyta FROM AppBundle:wizyta wizyta
        WHERE wizyta.data
        BETWEEN :startData AND :endData
        ')
            ->setParameter('startData',$start->format('Y-m-d'))
            ->setParameter('endData',$end->format('Y-m-d'))
            ->getResult();
        return $q;
    }
    public function getWizytaByIdLekarzDate($idLekarz, $start, $end){
        $q=$this->getEntityManager()->createQuery('
        SELECT wizyta
        FROM AppBundle:wizyta AS wizyta
        WHERE wizyta.data 
        BETWEEN :startData AND :endData
        AND wizyta.idLekarzGodzPrzyj IN (
        SELECT lekarzGodzPrzyj
        FROM AppBundle:lekarz_godz_przyj AS lekarzGodzPrzyj
        WHERE lekarzGodzPrzyj.idLekarz = :idLekarz
        )
        ')->setParameter('startData',$start->format('Y-m-d'))
            ->setParameter('endData',$end->format('Y-m-d'))
            ->setParameter('idLekarz',$idLekarz)
            ->getResult();
        return $q;
    }
    public function getWizytaByUserDate($user, $start, $end){
        $q=$this->getEntityManager()->createQuery('
        SELECT wizyta
        FROM AppBundle:wizyta AS wizyta
        WHERE wizyta.data 
        BETWEEN :startData AND :endData
        AND (wizyta.idPacjent = :idPacjent
        OR wizyta.idLekarzGodzPrzyj IN (
        SELECT lekarzGodzPrzyj
        FROM AppBundle:lekarz_godz_przyj AS lekarzGodzPrzyj
        WHERE lekarzGodzPrzyj.idLekarz = :idLekarz
        ))
        ')->setParameter('startData',$start->format('Y-m-d'))
            ->setParameter('endData',$end->format('Y-m-d'))
            ->setParameter('idPacjent',$user->getIdPacjent())
            ->setParameter('idLekarz',$user->getIdLekarz())
            ->getResult();
        return $q;
    }
}
