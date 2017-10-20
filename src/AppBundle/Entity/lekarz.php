<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="tytul", type="string", length=10, nullable=true)
     */
    private $tytul;


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
}

