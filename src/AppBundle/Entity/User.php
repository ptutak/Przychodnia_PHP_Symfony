<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    private $name;

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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Group", mappedBy="users")
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
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @param integer $idLekarz
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
     * @return int
     */
    public function getIdLekarz()
    {
        return $this->idLekarz;
    }

    public function __toString()
    {
        return parent::__toString()." ".$this->name;
    }

}

