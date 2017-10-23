<?php

namespace AppBundle\Entity;

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
     * @ORM\ManyToOne(targetEntity="pacjent")
     * @ORM\JoinColumn(name="id_pacjent",referencedColumnName="id")
     */
    private $idPacjent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_wizyty", type="date")
     */
    private $dataWizyty;

    /**
     * @ORM\ManyToOne(targetEntity="lekarz_godz_przyj")
     * @ORM\JoinColumn(name="id_lekarz_godz_przyj", referencedColumnName="id")
     */
    private $idLekarzGodzPrzyj;

    /**
     * @ORM\ManyToMany(targetEntity="leki")
     * @ORM\JoinTable(name="leki",
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
     * @param \DateTime $dataWizyty
     *
     * @return wizyta
     */
    public function setDataWizyty($dataWizyty)
    {
        $this->dataWizyty = $dataWizyty;

        return $this;
    }

    /**
     * Get dataWizyty
     *
     * @return \DateTime
     */
    public function getDataWizyty()
    {
        return $this->dataWizyty;
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
     * @return int
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
}

