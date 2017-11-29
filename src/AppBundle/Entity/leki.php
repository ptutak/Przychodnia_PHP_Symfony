<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * leki
 *
 * @ORM\Table(name="leki")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\lekiRepository")
 */
class leki
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
     * @ORM\Column(name="nazwa", type="string", length=255)
     */
    private $nazwa;

    /**
     * @var string
     *
     * @ORM\Column(name="producent", type="string", length=255)
     */
    private $producent;

    /**
     * @var string
     *
     * @ORM\Column(name="zastosowanie", type="text", nullable=true)
     */
    private $zastosowanie;


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
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return leki
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * Set producent
     *
     * @param string $producent
     *
     * @return leki
     */
    public function setProducent($producent)
    {
        $this->producent = $producent;

        return $this;
    }

    /**
     * Get producent
     *
     * @return string
     */
    public function getProducent()
    {
        return $this->producent;
    }

    /**
     * Set zastosowanie
     *
     * @param string $zastosowanie
     *
     * @return leki
     */
    public function setZastosowanie($zastosowanie)
    {
        $this->zastosowanie = $zastosowanie;

        return $this;
    }

    /**
     * Get zastosowanie
     *
     * @return string
     */
    public function getZastosowanie()
    {
        return $this->zastosowanie;
    }

    public function __toString()
    {
        return $this->nazwa.$this->producent;
    }
}

