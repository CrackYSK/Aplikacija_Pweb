<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as Assert;

/**
 * Rad
 *
 * @ORM\Table(name="rad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RadRepository")
 */
class Rad
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
     * @ORM\Column(name="naslov", type="string", length=100)
     */
    private $naslov;

    /**
     *
     * @ORM\Column(name="apstrakt", type="string", length=100)
     */
    private $apstrakt;

    /**
     * @var SmotraRadova
     *
     * @ORM\ManyToOne(targetEntity="SmotraRadova", inversedBy="rad", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="smotra_radova_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $smotraRadova;

    /**
     * @var Autor
     *
     * @ORM\OneToMany(targetEntity="Autor", mappedBy="rad", cascade={"persist", "remove"})
     */
    private $autor;

    public function __construct()
    {
        $this->autor = new ArrayCollection();
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
     * Set naslov
     *
     * @param string $naslov
     *
     * @return Rad
     */
    public function setNaslov($naslov)
    {
        $this->naslov = $naslov;

        return $this;
    }

    /**
     * Get naslov
     *
     * @return string
     */
    public function getNaslov()
    {
        return $this->naslov;
    }

    /**
     * Set apstrakt
     *
     * @param string $apstrakt
     *
     * @return Rad
     */
    public function setApstrakt($apstrakt)
    {
        $this->apstrakt = $apstrakt;

        return $this;
    }

    /**
     * Get apstrakt
     *
     * @return string
     */
    public function getApstrakt()
    {
        return $this->apstrakt;
    }

    /**
     * @return Autor
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param Autor $autor
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
    }

    /**
     * @return SmotraRadova
     */
    public function getSmotraRadova()
    {
        return $this->smotraRadova;
    }

    /**
     * @param SmotraRadova $smotraRadova
     */
    public function setSmotraRadova($smotraRadova)
    {
        $this->smotraRadova = $smotraRadova;
    }
}

