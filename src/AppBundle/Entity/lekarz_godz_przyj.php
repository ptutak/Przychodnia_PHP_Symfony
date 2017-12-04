<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var boolean
     * @ORM\Column (name="aktywna", type="boolean", nullable=true)
     */
    private $aktywna;



    /**
     * @ORM\ManyToOne(targetEntity="lekarz",inversedBy="godzPrzyj")
     * @ORM\JoinColumn(name="id_lekarz", referencedColumnName="id")
     */
    private $idLekarz;

    /**
     * @ORM\ManyToOne(targetEntity="godz_przyj",cascade={"persist"})
     * @ORM\JoinColumn(name="id_godz_przyj", referencedColumnName="id")
     */
    private $idGodzPrzyj;

    /**
     * @ORM\OneToMany(targetEntity="wizyta",mappedBy="idLekarzGodzPrzyj")
     */
    private $wizyty;


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
     * @return bool
     */
    public function isAktywna()
    {
        return $this->aktywna;
    }

    /**
     * @param bool
     * @return lekarz_godz_przyj
     */
    public function setAktywna($aktywna)
    {
        $this->aktywna = $aktywna;
        return $this;
    }

    /**
     * Set idGodzPrzyj
     *
     * @param godz_przyj $idGodzPrzyj
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
     * @return godz_przyj
     */
    public function getIdGodzPrzyj()
    {
        return $this->idGodzPrzyj;
    }

    /**
     * Set idLekarz
     *
     * @param lekarz $idLekarz
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
     * @return lekarz
     */
    public function getIdLekarz()
    {
        return $this->idLekarz;
    }

    /**
     * Set wizyty
     *
     * @param ArrayCollection $wizyty
     *
     * @return lekarz_godz_przyj
     */
    public function setWizyty($wizyty)
    {
        $this->wizyty = $wizyty;

        return $this;
    }

    /**
     * Get wizyty
     *
     * @return ArrayCollection
     */
    public function getWizyty()
    {
        return $this->wizyty;
    }

    public function __construct()
    {
        $this->wizyty = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->idLekarz.",\n".$this->idGodzPrzyj;
    }

    /**
     * @param lekarz $lekarz
     * @param godz_przyj $godz_przyj
     * @return $this
     */
    public function addLekarzGodzPrzyj(lekarz $lekarz, godz_przyj $godz_przyj){
        $this->setIdLekarz($lekarz);
        $this->setIdGodzPrzyj($godz_przyj);
        return $this;
    }

}

