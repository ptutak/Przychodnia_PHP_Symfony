<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * lekarz_urlopy
 *
 * @ORM\Table(name="lekarz_urlopy")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\lekarz_urlopyRepository")
 */
class lekarz_urlopy
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
     * @ORM\Column(name="id_lekarz", type="integer")
     */
    private $idLekarz;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_urlop", type="date")
     */
    private $dataUrlop;


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
     * Set idLekarz
     *
     * @param integer $idLekarz
     *
     * @return lekarz_urlopy
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
     * Set dataUrlop
     *
     * @param \DateTime $dataUrlop
     *
     * @return lekarz_urlopy
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
}

