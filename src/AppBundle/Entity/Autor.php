<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Autor
 *
 * @ORM\Table(name="autor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AutorRepository")
 */
class Autor
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
     * @ORM\Column(name="redosled", type="integer")
     */
    private $redosled;

    /**
     * @var Rad
     *
     * @ORM\ManyToOne(targetEntity="Rad", inversedBy="autor")
     * @ORM\JoinColumn(name="rad_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $rad;


    /**
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="autor", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $student;

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
     * Set redosled
     *
     * @param integer $redosled
     *
     * @return Autor
     */
    public function setRedosled($redosled)
    {
        $this->redosled = $redosled;

        return $this;
    }

    /**
     * Get redosled
     *
     * @return int
     */
    public function getRedosled()
    {
        return $this->redosled;
    }

    /**
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param Student $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return Rad
     */
    public function getRad()
    {
        return $this->rad;
    }

    /**
     * @param Rad $rad
     */
    public function setRad($rad)
    {
        $this->rad = $rad;
    }
}

