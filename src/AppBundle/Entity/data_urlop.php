<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * data_urlop
 *
 * @ORM\Table(name="data_urlop")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\data_urlopRepository")
 */
class data_urlop
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
     * @ORM\Column(name="data_urlop", type="date")
     */
    private $dataUrlop;

    /**
     * @ORM\ManyToMany(targetEntity="lekarz", mappedBy="urlopy")
     */
    private $lekarze;


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
     * Set dataUrlop
     *
     * @param \DateTime $dataUrlop
     *
     * @return data_urlop
     */
    public function setDataUrlop($dataUrlop)
    {
        $this->dataUrlop = $dataUrlop;

        return $this;
    }

    /**
     * Get dataUrlop
     *
     * @return \DateTime
     */
    public function getDataUrlop()
    {
        return $this->dataUrlop;
    }

    /**
     * Set lekarze
     *
     * @param integer $lekarze
     *
     * @return data_urlop
     */
    public function setLekarze($lekarze)
    {
        $this->lekarze = $lekarze;

        return $this;
    }

    /**
     * Get lekarze
     *
     * @return ArrayCollection
     */
    public function getLekarze()
    {
        return $this->lekarze;
    }

    public function __construct()
    {
        $this->lekarze = new ArrayCollection();
    }

    public function __toString()
    {
        return strval($this->dataUrlop);
    }

}

