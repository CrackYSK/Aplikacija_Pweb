<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Takmicenje
 *
 * @ORM\Table(name="takmicenje")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TakmicenjeRepository")
 * @UniqueEntity(
 *     fields={"dogadjaj","kategorija"},
 *     errorPath="kategorija"
 *     )
 *
 */
class Takmicenje
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
     * @ORM\Column(name="brojSlobodnihMesta", type="integer")
     */
    private $brojSlobodnihMesta;


    /**
     * @var Prijava
     *
     * @ORM\OneToMany(targetEntity="Prijava", mappedBy="takmicenje")
     */
    private $prijava;

    public function __construct()
    {
        $this->prijava = new ArrayCollection();
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
     *
     * @var Kategorija
     *
     * @ORM\ManyToOne(targetEntity="Kategorija", inversedBy="takmicenje")
     * @ORM\JoinColumn(name="kategorija_id", referencedColumnName="id", onDelete="CASCADE");
     *
     */
    private $kategorija;

    /**
     * @return Kategorija
     */
    public function getKategorija(){
        return $this->kategorija;
    }

    public function setKategorija(Kategorija $kategorija){
        $this->kategorija = $kategorija;
    }


    /**
     * @var Dogadjaj
     *
     * @ORM\ManyToOne(targetEntity="Dogadjaj")
     * @ORM\JoinColumn(name="dogadjaj_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $dogadjaj;

    /**
     * @return Dogadjaj
     */
    public function getDogadjaj() {
        return $this->dogadjaj;
    }

    public function setDogadjaj(Dogadjaj $dogadjaj) {
        $this->dogadjaj = $dogadjaj;
    }

    /**
     * Set brojSlobodnihMesta
     *
     * @param integer $brojSlobodnihMesta
     *
     * @return Takmicenje
     */
    public function setBrojSlobodnihMesta($brojSlobodnihMesta)
    {
        $this->brojSlobodnihMesta = $brojSlobodnihMesta;

        return $this;
    }

    /**
     * Get brojSlobodnihMesta
     *
     * @return int
     */
    public function getBrojSlobodnihMesta()
    {
        return $this->brojSlobodnihMesta;
    }

    public function __toString()
    {
        return $this->getKategorija()->getNaziv();
    }
}

