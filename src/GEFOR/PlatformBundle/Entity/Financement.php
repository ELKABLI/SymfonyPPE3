<?php

namespace GEFOR\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Financement
 *
 * @ORM\Table(name="financement")
 * @ORM\Entity(repositoryClass="GEFOR\PlatformBundle\Repository\FinancementRepository")
 */
class Financement
{   

    /**
     * @ORM\OneToMany(targetEntity="GEFOR\PlatformBundle\Entity\Candidat", mappedBy="financement", cascade={"persist"})
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


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
     * Set type
     *
     * @param string $type
     *
     * @return Financement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * @return Financement
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
