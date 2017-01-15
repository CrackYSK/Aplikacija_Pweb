<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tim
 *
 * @ORM\Table(name="tim")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TimRepository")
 */
class Tim
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
     * @ORM\Column(name="naziv", type="string", length=50)
     */
    private $naziv;

    /**
     * @var int
     *
     * @ORM\Column(name="plasman", type="integer", nullable=true)
     */
    private $plasman;

    /**
     * @var string
     *
     * @ORM\Column(name="nagrada", type="string", length=100, nullable=true)
     */
    private $nagrada;

    /**
     * @var Prijava
     *
     * @ORM\OneToOne(targetEntity="Prijava", inversedBy="tim")
     * @ORM\JoinColumn(name="prijava_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $prijava;

    /**
     * @var Ucesnik
     *
     * @ORM\OneToMany(targetEntity="Ucesnik", mappedBy="tim", cascade={"persist", "remove"})
     */
    private $ucesnik;

    public function __construct()
    {
        $this->ucesnik = new ArrayCollection();
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
     * @return Tim
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
     * Set plasman
     *
     * @param integer $plasman
     *
     * @return Tim
     */
    public function setPlasman($plasman)
    {
        $this->plasman = $plasman;

        return $this;
    }

    /**
     * Get plasman
     *
     * @return int
     */
    public function getPlasman()
    {
        return $this->plasman;
    }

    /**
     * Set nagrada
     *
     * @param string $nagrada
     *
     * @return Tim
     */
    public function setNagrada($nagrada)
    {
        $this->nagrada = $nagrada;

        return $this;
    }

    /**
     * Get nagrada
     *
     * @return string
     */
    public function getNagrada()
    {
        return $this->nagrada;
    }

    public function getUcesnik() {
        return $this->ucesnik;
    }

    public function setUcesnik(Ucesnik $ucesnik) {
        $this->ucesnik=$ucesnik;
    }

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
}

