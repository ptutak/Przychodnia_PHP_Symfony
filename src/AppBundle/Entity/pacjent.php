<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * pacjent
 *
 * @ORM\Table(name="pacjent")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\pacjentRepository")
 */
class pacjent
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
     * @var int
     *
     * @ORM\Column(name="PESEL", type="bigint", unique=true)
     */
    private $pESEL;

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
     * @ORM\Column(name="miasto", type="string", length=50, nullable=true)
     */
    private $miasto;

    /**
     * @var string
     *
     * @ORM\Column(name="ulica", type="string", length=50, nullable=true)
     */
    private $ulica;

    /**
     * @var string
     *
     * @ORM\Column(name="numer", type="string", length=10, nullable=true)
     */
    private $numer;


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
     * Set pESEL
     *
     * @param integer $pESEL
     *
     * @return pacjent
     */
    public function setPESEL($pESEL)
    {
        $this->pESEL = $pESEL;

        return $this;
    }

    /**
     * Get pESEL
     *
     * @return int
     */
    public function getPESEL()
    {
        return $this->pESEL;
    }

    /**
     * Set imie
     *
     * @param string $imie
     *
     * @return pacjent
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
     * @return pacjent
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
     * Set miasto
     *
     * @param string $miasto
     *
     * @return pacjent
     */
    public function setMiasto($miasto)
    {
        $this->miasto = $miasto;

        return $this;
    }

    /**
     * Get miasto
     *
     * @return string
     */
    public function getMiasto()
    {
        return $this->miasto;
    }

    /**
     * Set ulica
     *
     * @param string $ulica
     *
     * @return pacjent
     */
    public function setUlica($ulica)
    {
        $this->ulica = $ulica;

        return $this;
    }

    /**
     * Get ulica
     *
     * @return string
     */
    public function getUlica()
    {
        return $this->ulica;
    }

    /**
     * Set numer
     *
     * @param string $numer
     *
     * @return pacjent
     */
    public function setNumer($numer)
    {
        $this->numer = $numer;

        return $this;
    }

    public function __toString()
    {
        return $this->nazwisko.$this->imie.$this->pESEL;
    }

    /**
     * Get numer
     *
     * @return string
     */
    public function getNumer()
    {
        return $this->numer;
    }
}

