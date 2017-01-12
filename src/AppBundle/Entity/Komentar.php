<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Komentar
 *
 * @ORM\Table(name="komentar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KomentarRepository")
 */
class Komentar
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
     * @ORM\Column(name="komentar", type="string", length=375, nullable=true)
     */
    private $komentar;

    /**
     * @var int
     *
     * @ORM\Column(name="za", type="integer")
     */
    private $za;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="komentar")
     * @ORM\JoinColumn(name="id_komentator", referencedColumnName="id")
     */
    private $komentator;


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
     * Set komentar
     *
     * @param string $komentar
     *
     * @return Komentar
     */
    public function setKomentar($komentar)
    {
        $this->komentar = $komentar;

        return $this;
    }

    /**
     * Get komentar
     *
     * @return string
     */
    public function getKomentar()
    {
        return $this->komentar;
    }

    /**
     * Set za
     *
     * @param integer $za
     *
     * @return Komentar
     */
    public function setZa($za)
    {
        $this->za = $za;

        return $this;
    }

    /**
     * Get za
     *
     * @return int
     */
    public function getZa()
    {
        return $this->za;
    }
}

