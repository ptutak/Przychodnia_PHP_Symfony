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
     * @ORM\Column(name="indeks", type="string", length=20, unique=true)
     */
    private $indeks;

    /**
     * @var int
     *
     * @ORM\Column(name="id_pacjent", type="integer")
     */
    private $idPacjent;

    /**
     * @var int
     *
     * @ORM\Column(name="id_lekarz", type="integer")
     */
    private $idLekarz;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_wizyty", type="date")
     */
    private $dataWizyty;

    /**
     * @var int
     *
     * @ORM\Column(name="id_godz_przyj", type="integer")
     */
    private $idGodzPrzyj;

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
     * Set idLekarz
     *
     * @param integer $idLekarz
     *
     * @return wizyta
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
     * Set idGodzPrzyj
     *
     * @param integer $idGodzPrzyj
     *
     * @return wizyta
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

