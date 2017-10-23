<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * data_urlop_lekarz
 *
 * @ORM\Table(name="data_urlop_lekarz")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\data_urlop_lekarzRepository")
 */
class data_urlop_lekarz
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
     * @var int
     *
     * @ORM\Column(name="id_lekarz", type="integer")
     */
    private $idLekarz;


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
     * @return data_urlop_lekarz
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
     * Set idLekarz
     *
     * @param integer $idLekarz
     *
     * @return data_urlop_lekarz
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
}

