<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * godz_przyj
 *
 * @ORM\Table(name="godz_przyj")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\godz_przyjRepository")
 */
class godz_przyj
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
     * @var \DateTime
     *
     * @ORM\Column(name="godz_poczatek", type="time")
     */
    private $godzPoczatek;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="godz_koniec", type="time")
     */
    private $godzKoniec;


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
     * Set godzPoczatek
     *
     * @param \DateTime $godzPoczatek
     *
     * @return godz_przyj
     */
    public function setGodzPoczatek($godzPoczatek)
    {
        $this->godzPoczatek = $godzPoczatek;

        return $this;
    }

    /**
     * Get godzPoczatek
     *
     * @return \DateTime
     */
    public function getGodzPoczatek()
    {
        return $this->godzPoczatek;
    }

    /**
     * Set godzKoniec
     *
     * @param \DateTime $godzKoniec
     *
     * @return godz_przyj
     */
    public function setGodzKoniec($godzKoniec)
    {
        $this->godzKoniec = $godzKoniec;

        return $this;
    }

    /**
     * Get godzKoniec
     *
     * @return \DateTime
     */
    public function getGodzKoniec()
    {
        return $this->godzKoniec;
    }
}

