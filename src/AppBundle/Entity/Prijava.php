<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prijava
 *
 * @ORM\Table(name="prijava")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrijavaRepository")
 */
class Prijava
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
     * @ORM\Column(name="datum", type="date")
     */
    private $datum;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;


    /**
     * @var Tim
     *
     * @ORM\OneToOne(targetEntity="Tim", mappedBy="prijava")
     */
    private $tim;

    /**
     * @var Takmicenje
     *
     * @ORM\ManyToOne(targetEntity="Takmicenje", inversedBy="prijava")
     * @ORM\JoinColumn(name="takmicenje_id", referencedColumnName="id")
     */
    private $takmicenje;

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
     * Set datum
     *
     * @param \DateTime $datum
     *
     * @return Prijava
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

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Prijava
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function getTakmicenje() {
        return $this->takmicenje;
    }

    public function setTakmicenje(Takmicenje $takmicenje) {
        $this->takmicenje = $takmicenje;
    }

    public function getTim() {
        return $this->tim;
    }

    public function setTim(Tim $tim) {
        $this->tim = $tim;
    }

}

