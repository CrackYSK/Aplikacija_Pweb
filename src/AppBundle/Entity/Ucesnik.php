<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ucesnik
 *
 * @ORM\MappedSuperclass
 *
 */
class Ucesnik
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
     * @ORM\Column(name="ime", type="string", length=20)
     */
    private $ime;

    /**
     * @var string
     *
     * @ORM\Column(name="prezime", type="string", length=20)
     */
    private $prezime;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="prethodnaIskustva", type="string", length=200)
     */
    private $prethodnaIskustva;

    /**
     * @ORM\Column(name="CV", type="string", length=100, nullable=true)
     * @Assert\File(
     *     mimeTypes={ "application/pdf", "application/x-pdf" },
     *     mimeTypesMessage = "CV-образац мора бити у PDF формату")
     */
    private $cV;

    /**
     * @var Tim
     *
     * @ORM\ManyToOne(targetEntity="Tim", inversedBy="ucesnik")
     * @ORM\JoinColumn(name="tim_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $tim;

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
     * @return Ucesnik
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
     * Set prezime
     *
     * @param string $prezime
     *
     * @return Ucesnik
     */
    public function setPrezime($prezime)
    {
        $this->prezime = $prezime;

        return $this;
    }

    /**
     * Get prezime
     *
     * @return string
     */
    public function getPrezime()
    {
        return $this->prezime;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Ucesnik
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set prethodnaIskustva
     *
     * @param string $prethodnaIskustva
     *
     * @return Ucesnik
     */
    public function setPrethodnaIskustva($prethodnaIskustva)
    {
        $this->prethodnaIskustva = $prethodnaIskustva;

        return $this;
    }

    /**
     * Get prethodnaIskustva
     *
     * @return string
     */
    public function getPrethodnaIskustva()
    {
        return $this->prethodnaIskustva;
    }

    /**
     * Set cV
     *
     * @param string $cV
     *
     * @return Ucesnik
     */
    public function setCV($cV)
    {
        $this->cV = $cV;

        return $this;
    }

    /**
     * Get cV
     *
     * @return string
     */
    public function getCV()
    {
        return $this->cV;
    }

    /**
     * @return Tim
     */
    public function getTim()
    {
        return $this->tim;
    }

    /**
     * @param Tim $tim
     */
    public function setTim($tim)
    {
        $this->tim = $tim;
    }
}

