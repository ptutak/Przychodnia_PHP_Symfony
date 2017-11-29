<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

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
     * @ORM\Column(name="data", type="date", unique=true)
     */
    private $data;

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
     * Set data
     *
     * @param \DateTime $data
     *
     * @return data_urlop
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
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

    /**
     * @param lekarz $lekarz
     * @return $this
     */
    public function addLekarz(lekarz $lekarz){
        $this->lekarze->add($lekarz);
        return $this;
    }

    /**
     * @param lekarz $lekarz
     * @return $this
     */
    public function removeLekarz(lekarz $lekarz){
        $this->lekarze->removeElement($lekarz);
        if ($this->lekarze->count()==0){

        }
        return $this;
    }

    public function __toString()
    {
        return $this->data->format('Y-m-d');
    }
}

