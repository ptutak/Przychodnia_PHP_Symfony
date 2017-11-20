<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * lekarz
 *
 * @ORM\Table(name="lekarz")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\lekarzRepository")
 */
class lekarz
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
     * @var string
     *
     * @ORM\Column(name="imie", type="string", length=50)
     */
    private $imie;

    /**
     * @var string
     *
     * @ORM\Column(name="nazwisko", type="string", length=50)
     */
    private $nazwisko;

    /**
     * @var string
     *
     * @ORM\Column(name="tytul", type="string", length=50, nullable=true)
     */
    private $tytul;

    /**
     * @ORM\ManyToMany(targetEntity="specjalizacja")
     * @ORM\JoinTable(name="lekarz_specjalizacja",
     *     joinColumns={@ORM\JoinColumn(name="id_lekarz",referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="id_specjalizacja",referencedColumnName="id")}
     *     )
     */
    private $specjalizacje;

    /**
     * @ORM\OneToMany(targetEntity="lekarz_godz_przyj", mappedBy="idLekarz")
     */
    private $godzPrzyj;

    /**
     * @ORM\ManyToMany(targetEntity="data_urlop",inversedBy="lekarze", cascade={"persist"})
     * @ORM\JoinTable(name="lekarz_data_urlop")
     */
    private $urlopy;


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
     * Set imie
     *
     * @param string $imie
     *
     * @return lekarz
     */
    public function setImie($imie)
    {
        $this->imie = $imie;

        return $this;
    }

    /**
     * Get imie
     *
     * @return string
     */
    public function getImie()
    {
        return $this->imie;
    }

    /**
     * Set nazwisko
     *
     * @param string $nazwisko
     *
     * @return lekarz
     */
    public function setNazwisko($nazwisko)
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    /**
     * Get nazwisko
     *
     * @return string
     */
    public function getNazwisko()
    {
        return $this->nazwisko;
    }

    /**
     * Set tytul
     *
     * @param string $tytul
     *
     * @return lekarz
     */
    public function setTytul($tytul)
    {
        $this->tytul = $tytul;

        return $this;
    }

    /**
     * Get tytul
     *
     * @return string
     */
    public function getTytul()
    {
        return $this->tytul;
    }

    /**
     * Set specjalizacje
     *
     * @param integer $specjalizacje
     *
     * @return lekarz
     */
    public function setSpecjalizacje($specjalizacje)
    {
        $this->specjalizacje = $specjalizacje;

        return $this;
    }

    /**
     * Get specjalizacje
     *
     * @return ArrayCollection
     */
    public function getSpecjalizacje()
    {
        return $this->specjalizacje;
    }

    /**
     * Set godzPrzyj
     *
     * @param integer $godzPrzyj
     *
     * @return lekarz
     */
    public function setGodzPrzyj($godzPrzyj)
    {
        $this->godzPrzyj = $godzPrzyj;

        return $this;
    }

    /**
     * Get godzPrzyj
     *
     * @return ArrayCollection
     */
    public function getGodzPrzyj()
    {
        return $this->godzPrzyj;
    }

    /**
     * Set urlopy
     *
     * @param integer $urlopy
     *
     * @return lekarz
     */
    public function setUrlopy($urlopy)
    {
        $this->urlopy = $urlopy;

        return $this;
    }

    /**
     * Get urlopy
     *
     * @return ArrayCollection
     */
    public function getUrlopy()
    {
        return $this->urlopy;
    }
    public function __construct()
    {
        $this->godzPrzyj = new ArrayCollection();
        $this->urlopy = new ArrayCollection();
        $this->specjalizacje = new ArrayCollection();
    }

    /**
     * @param data_urlop $dataUrlop
     * @return $this
     */
    public function addUrlop(data_urlop $dataUrlop){
        $this->urlopy->add($dataUrlop);
        return $this;
    }

    /**
     * @param data_urlop $dataUrlop
     * @return $this
     */
    public function removeUrlop(data_urlop $dataUrlop){
        $this->urlopy->removeElement($dataUrlop);
        return $this;
    }


    public function __toString()
    {
        return $this->imie." ".$this->nazwisko." ".$this->tytul;
    }
}

