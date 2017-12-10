<?php

namespace GEFOR\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agenda
 *
 * @ORM\Table(name="agenda")
 * @ORM\Entity(repositoryClass="GEFOR\PlatformBundle\Repository\AgendaRepository")
 */
class Agenda
{   
    /**
     * @ORM\OneToMany(targetEntity="GEFOR\PlatformBundle\Entity\Candidat", mappedBy="agenda", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $candidats;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", unique=true)
     */
    private $date;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Agenda
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->candidats = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add candidat
     *
     * @param \GEFOR\PlatformBundle\Entity\Candidat $candidat
     *
     * @return Agenda
     */
    public function addCandidat(\GEFOR\PlatformBundle\Entity\Candidat $candidat)
    {
        $this->candidats[] = $candidat;

        return $this;
    }

    /**
     * Remove candidat
     *
     * @param \GEFOR\PlatformBundle\Entity\Candidat $candidat
     */
    public function removeCandidat(\GEFOR\PlatformBundle\Entity\Candidat $candidat)
    {
        $this->candidats->removeElement($candidat);
    }

    /**
     * Get candidats
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCandidats()
    {
        return $this->candidats;
    }
}
