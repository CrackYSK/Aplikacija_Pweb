<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Kategorija
 *
 * @ORM\Table(name="kategorija")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KategorijaRepository")
 */
class Kategorija
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
     * @ORM\Column(name="naziv", type="string", length=100, unique=true)
     */
    private $naziv;

    /**
     * @var int
     *
     * @ORM\Column(name="brojTimova", type="integer")
     */
    private $brojTimova;

    /**
     * @var int
     *
     * @ORM\Column(name="brojClanovaTima", type="integer")
     */
    private $brojClanovaTima;

    /**
     * @var bool
     *
     * @ORM\Column(name="studentska", type="boolean")
     */
    private $studentska;


    /**
     * @var Takmicenje
     *
     * @ORM\OneToMany(targetEntity="Takmicenje", mappedBy="kategorija")
     */
    private $takmicenje;

    public function __construct()
    {
        $this->takmicenje = new ArrayCollection();
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
     * Set naziv
     *
     * @param string $naziv
     *
     * @return Kategorija
     */
    public function setNaziv($naziv)
    {
        $this->naziv = $naziv;

        return $this;
    }

    /**
     * Get naziv
     *
     * @return string
     */
    public function getNaziv()
    {
        return $this->naziv;
    }

    /**
     * Set brojTimova
     *
     * @param integer $brojTimova
     *
     * @return Kategorija
     */
    public function setBrojTimova($brojTimova)
    {
        $this->brojTimova = $brojTimova;

        return $this;
    }

    /**
     * Get brojTimova
     *
     * @return int
     */
    public function getBrojTimova()
    {
        return $this->brojTimova;
    }

    /**
     * Set brojClanovaTima
     *
     * @param integer $brojClanovaTima
     *
     * @return Kategorija
     */
    public function setBrojClanovaTima($brojClanovaTima)
    {
        $this->brojClanovaTima = $brojClanovaTima;

        return $this;
    }

    /**
     * Get brojClanovaTima
     *
     * @return int
     */
    public function getBrojClanovaTima()
    {
        return $this->brojClanovaTima;
    }

    /**
     * Set studentska
     *
     * @param boolean $studentska
     *
     * @return Kategorija
     */
    public function setStudentska($studentska)
    {
        $this->studentska = $studentska;

        return $this;
    }

    /**
     * Get studentska
     *
     * @return bool
     */
    public function getStudentska()
    {
        return $this->studentska;
    }

    public function __toString()
    {
        return $this->naziv;
    }
}

