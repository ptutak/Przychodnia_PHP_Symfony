<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * wizyta
 *
 * @ORM\Table(name="wizyta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\wizytaRepository")
 */
class wizyta
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
     * @ORM\Column(name="indeks", type="string", length=50, unique=true)
     */
    private $indeks;

    /**
     * @ORM\ManyToOne(targetEntity="pacjent",inversedBy="wizyty")
     * @ORM\JoinColumn(name="id_pacjent",referencedColumnName="id")
     */
    private $idPacjent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="date")
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity="lekarz_godz_przyj", inversedBy="wizyty")
     * @ORM\JoinColumn(name="id_lekarz_godz_przyj", referencedColumnName="id")
     */
    private $idLekarzGodzPrzyj;

    /**
     * @ORM\ManyToMany(targetEntity="leki")
     * @ORM\JoinTable(name="wizyta_leki",
     *     joinColumns={@ORM\JoinColumn(name="id_wizyta", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="id_lek", referencedColumnName="id")}
     *     )
     */
    private $leki;

    /**
     * @var string
     *
     * @ORM\Column(name="diagnoza", type="text", nullable=true)
     */
    private $diagnoza;


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
     * Set indeks
     *
     * @param string $indeks
     *
     * @return wizyta
     */
    public function setIndeks($indeks)
    {
        $this->indeks = $indeks;

        return $this;
    }

    /**
     * Get indeks
     *
     * @return string
     */
    public function getIndeks()
    {
        return $this->indeks;
    }

    /**
     * Set idPacjent
     *
     * @param integer $idPacjent
     *
     * @return wizyta
     */
    public function setIdPacjent($idPacjent)
    {
        $this->idPacjent = $idPacjent;

        return $this;
    }

    /**
     * Get idPacjent
     *
     * @return int
     */
    public function getIdPacjent()
    {
        return $this->idPacjent;
    }

    /**
     * Set dataWizyty
     *
     * @param \DateTime $data
     *
     * @return wizyta
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get dataWizyty
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set idLekarzGodzPrzyj
     *
     * @param integer $idLekarzGodzPrzyj
     *
     * @return wizyta
     */
    public function setIdLekarzGodzPrzyj($idLekarzGodzPrzyj)
    {
        $this->idLekarzGodzPrzyj = $idLekarzGodzPrzyj;

        return $this;
    }

    /**
     * Get idLekarzGodzPrzyj
     *
     * @return int
     */
    public function getIdLekarzGodzPrzyj()
    {
        return $this->idLekarzGodzPrzyj;
    }

    /**
     * Set leki
     *
     * @param integer $leki
     *
     * @return wizyta
     */
    public function setLeki($leki)
    {
        $this->leki = $leki;

        return $this;
    }

    /**
     * Get leki
     *
     * @return ArrayCollection
     */
    public function getLeki()
    {
        return $this->leki;
    }

    /**
     * Set diagnoza
     *
     * @param string $diagnoza
     *
     * @return wizyta
     */
    public function setDiagnoza($diagnoza)
    {
        $this->diagnoza = $diagnoza;

        return $this;
    }

    /**
     * Get diagnoza
     *
     * @return string
     */
    public function getDiagnoza()
    {
        return $this->diagnoza;
    }

    public function __construct()
    {
        $this->leki = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->indeks." ; ".$this->data->format("Y-m-d")." ; ".$this->idLekarzGodzPrzyj." ; ".$this->idPacjent;
    }
    public function getName()
    {
        return "Indeks:".$this->indeks.";\nData:".$this->data->format("Y-m-d").";\nLekarz, godz. przyjęcia:\n".$this->idLekarzGodzPrzyj.";\nPacjent:".$this->idPacjent;
    }

}

