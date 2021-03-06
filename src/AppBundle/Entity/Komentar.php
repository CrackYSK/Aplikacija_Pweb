<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Komentar
 *
 * @ORM\Table(name="komentar")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KomentarRepository")
 * @UniqueEntity(
 *     fields={"komentator","prijava"},
 *     errorPath="komentator",
 *     message="Већ постоји коментар овог члана комисије."
 *     )
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
     * @ORM\Column(name="za", type="boolean")
     */
    private $za;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="komentar")
     * @ORM\JoinColumn(name="id_komentator", referencedColumnName="id", onDelete="CASCADE")
     */
    private $komentator;

    /**
     * @var Prijava
     *
     * @ORM\ManyToOne(targetEntity="Prijava")
     * @ORM\JoinColumn(name="prijava_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $prijava;

    /**
     * @return Prijava
     */
    public function getPrijava()
    {
        return $this->prijava;
    }

    /**
     * @param Prijava $prijava
     */
    public function setPrijava($prijava)
    {
        $this->prijava = $prijava;
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

    /**
     * @return mixed
     */
    public function getKomentator()
    {
        return $this->komentator;
    }

    /**
     * @param mixed $komentator
     */
    public function setKomentator($komentator)
    {
        $this->komentator = $komentator;
    }
}

