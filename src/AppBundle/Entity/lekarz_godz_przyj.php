<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * lekarz_godz_przyj
 *
 * @ORM\Table(name="lekarz_godz_przyj")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\lekarz_godz_przyjRepository")
 */
class lekarz_godz_przyj
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="godz_przyj")
     * @ORM\JoinColumn(name="id_godz_przyj", referencedColumnName="id")
     */
    private $idGodzPrzyj;

    /**
     * @ORM\ManyToOne(targetEntity="lekarz")
     * @ORM\JoinColumn(name="id_lekarz", referencedColumnName="id")
     */
    private $idLekarz;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idGodzPrzyj
     *
     * @param integer $idGodzPrzyj
     *
     * @return lekarz_godz_przyj
     */
    public function setIdGodzPrzyj($idGodzPrzyj)
    {
        $this->idGodzPrzyj = $idGodzPrzyj;

        return $this;
    }

    /**
     * Get idGodzPrzyj
     *
     * @return int
     */
    public function getIdGodzPrzyj()
    {
        return $this->idGodzPrzyj;
    }

    /**
     * Set idLekarz
     *
     * @param integer $idLekarz
     *
     * @return lekarz_godz_przyj
     */
    public function setIdLekarz($idLekarz)
    {
        $this->idLekarz = $idLekarz;

        return $this;
    }

    /**
     * Get idLekarz
     *
     * @return int
     */
    public function getIdLekarz()
    {
        return $this->idLekarz;
    }
}

