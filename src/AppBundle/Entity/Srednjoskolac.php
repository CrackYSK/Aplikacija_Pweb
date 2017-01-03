<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Srednjoskolac
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SrednjoskolacRepository")
 */
class Srednjoskolac extends Ucesnik
{
    /**
     * @var string
     *
     * @ORM\Column(name="skola", type="string", length=50)
     */
    private $skola;

    /**
     * @var string
     *
     * @ORM\Column(name="odeljenje", type="string", length=10)
     */
    private $odeljenje;

    /**
     * @var string
     *
     * @ORM\Column(name="grad", type="string", length=20)
     */
    private $grad;

    /**
     * Set skola
     *
     * @param string $skola
     *
     * @return Srednjoskolac
     */
    public function setSkola($skola)
    {
        $this->skola = $skola;

        return $this;
    }

    /**
     * Get skola
     *
     * @return string
     */
    public function getSkola()
    {
        return $this->skola;
    }

    /**
     * Set odeljenje
     *
     * @param string $odeljenje
     *
     * @return Srednjoskolac
     */
    public function setOdeljenje($odeljenje)
    {
        $this->odeljenje = $odeljenje;

        return $this;
    }

    /**
     * Get odeljenje
     *
     * @return string
     */
    public function getOdeljenje()
    {
        return $this->odeljenje;
    }

    /**
     * Set grad
     *
     * @param string $grad
     *
     * @return Srednjoskolac
     */
    public function setGrad($grad)
    {
        $this->grad = $grad;

        return $this;
    }

    /**
     * Get grad
     *
     * @return string
     */
    public function getGrad()
    {
        return $this->grad;
    }
}

