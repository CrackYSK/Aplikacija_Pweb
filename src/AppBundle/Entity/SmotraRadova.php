<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SmotraRadova
 *
 * @ORM\Table(name="smotra_radova")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SmotraRadovaRepository")
 */
class SmotraRadova
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
     * @var Rad
     *
     * @ORM\OneToMany(targetEntity="Rad", mappedBy="smotraRadova")
     */
    private $rad;

    public function __construct()
    {
        $this->rad = new ArrayCollection();
    }

    /**
     * @var Dogadjaj
     *
     * @ORM\OneToOne(targetEntity="Dogadjaj")
     * @ORM\JoinColumn(name="dogadjaj_id", referencedColumnName="id")
     */
    private $dogadjaj;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

