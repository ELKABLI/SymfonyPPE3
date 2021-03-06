<?php

namespace GEFOR\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Formation
 *
 * @ORM\Table(name="formation")
 * @ORM\Entity(repositoryClass="GEFOR\PlatformBundle\Repository\FormationRepository")
 */
class Formation
{   
    /**
     * @ORM\OneToMany(targetEntity="GEFOR\PlatformBundle\Entity\Candidat", mappedBy="formation", cascade={"persist","remove"})
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
     * @ORM\Column(name="Type", type="string", length=255)
     * 
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
     * @return Formation
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
     * @return Formation
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
