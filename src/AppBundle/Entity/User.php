<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="lekarz")
     * @ORM\JoinColumn(name="id_lekarz", referencedColumnName="id")
     */
    private $idLekarz;

    /**
     * @ORM\OneToOne(targetEntity="pacjent")
     * @ORM\JoinColumn(name="id_pacjent", referencedColumnName="id")
     */
    private $idPacjent;

    /**
     * @ORM\ManyToMany(targetEntity="Group", mappedBy="users")
     */
    protected $groups;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
//        $this->groups = new ArrayCollection();
    }

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
     * Set idPacjent
     *
     * @param integer $idPacjent
     *
     * @return User
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
     * @param lekarz $idLekarz
     *
     * @return User
     */
    public function setIdLekarz($idLekarz)
    {
        $this->idLekarz = $idLekarz;

        return $this;
    }

    /**
     * Get idLekarz
     *
     * @return lekarz
     */
    public function getIdLekarz()
    {
        return $this->idLekarz;
    }

}

