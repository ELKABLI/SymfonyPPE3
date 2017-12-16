<?php

namespace GEFOR\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Situation
 *
 * @ORM\Table(name="situation")
 * @ORM\Entity(repositoryClass="GEFOR\PlatformBundle\Repository\SituationRepository")
 */
class Situation
{   

    /**
     * @ORM\OneToMany(targetEntity="GEFOR\PlatformBundle\Entity\Candidat", mappedBy="situation", cascade={"persist"})
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
     * @return Situation
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
     * Set candidat
     *
     * @param \GEFOR\PlatformBundle\Entity\Candidat $candidat
     *
     * @return Situation
     */
    public function setCandidat(\GEFOR\PlatformBundle\Entity\Candidat $candidat)
    {
        $this->candidat = $candidat;

        return $this;
    }

    /**
     * Get candidat
     *
     * @return \GEFOR\PlatformBundle\Entity\Candidat
     */
    public function getCandidat()
    {
        return $this->candidat;
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
     * @return Situation
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
