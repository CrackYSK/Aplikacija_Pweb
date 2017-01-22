<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudentRepository")
 */
class Student extends Ucesnik
{
    /**
     * @var string
     *
     * @ORM\Column(name="indeks", type="string", length=10)
     */
    private $indeks;

    /**
     * @var string
     *
     * @ORM\Column(name="smer", type="string", length=30)
     */
    private $smer;

    /**
     * @var bool
     *
     * @ORM\Column(name="aktivan", type="boolean")
     */
    private $aktivan;

    /**
     * @var Autor
     *
     * @ORM\OneToMany(targetEntity="Autor", mappedBy="student")
     */
    private $autor;

    public function __construct()
    {
        $this->autor = new ArrayCollection();
    }


    /**
     * Set indeks
     *
     * @param string $indeks
     *
     * @return Student
     */
    public function setIndeks($indeks)
    {
        $this->indeks = $indeks;

        return $this;
    }

    /**
     * Get indeks
     *
     * @return string
     */
    public function getIndeks()
    {
        return $this->indeks;
    }

    /**
     * Set smer
     *
     * @param string $smer
     *
     * @return Student
     */
    public function setSmer($smer)
    {
        $this->smer = $smer;

        return $this;
    }

    /**
     * Get smer
     *
     * @return string
     */
    public function getSmer()
    {
        return $this->smer;
    }

    /**
     * Set aktivan
     *
     * @param boolean $aktivan
     *
     * @return Student
     */
    public function setAktivan($aktivan)
    {
        $this->aktivan = $aktivan;

        return $this;
    }

    /**
     * Get aktivan
     *
     * @return bool
     */
    public function getAktivan()
    {
        return $this->aktivan;
    }

    /**
     * @param Autor $autor
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
    }

    /**
     * @return Autor
     */
    public function getAutor()
    {
        return $this->autor;
    }
}

