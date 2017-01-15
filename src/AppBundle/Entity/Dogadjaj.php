<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dogadjaj
 *
 * @ORM\Table(name="dogadjaj")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DogadjajRepository")
 */
class Dogadjaj
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
     * @ORM\Column(name="ime", type="string", length=50, unique=true)
     */
    private $ime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datum", type="date", unique=true)
     */
    private $datum;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="dogadjaj")
     * @ORM\JoinColumn(name="id_predsednik", referencedColumnName="id", onDelete="CASCADE")
     */
    private $predsednik;

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
     * Set ime
     *
     * @param string $ime
     *
     * @return Dogadjaj
     */
    public function setIme($ime)
    {
        $this->ime = $ime;

        return $this;
    }

    /**
     * Get ime
     *
     * @return string
     */
    public function getIme()
    {
        return $this->ime;
    }

    /**
     * Set datum
     *
     * @param \DateTime $datum
     *
     * @return Dogadjaj
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;

        return $this;
    }

    /**
     * Get datum
     *
     * @return \DateTime
     */
    public function getDatum()
    {
        return $this->datum;
    }

    public function __toString()
    {
        return $this->ime;
    }
    
    public function getPredsednik()
    {
        return $this->predsednik;
    }

    public function setPredsednik(User $user)
    {
        $this->predsednik=$user;
    }
}

