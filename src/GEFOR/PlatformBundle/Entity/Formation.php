<?php

namespace GEFOR\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Formation
 *
 * @ORM\Table(name="formation")
 * @ORM\Entity(repositoryClass="GEFOR\PlatformBundle\Repository\FormationRepository")
 */
class Formation
{   
    /**
    * @ORM\ManyToOne(targetEntity="GEFOR\PlatformBundle\Entity\Candidat",inversedBy="Formations")
    *@ORM\JoinColumn(nullable=false)
     */
    private $Candidat;



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
     * Set candidat
     *
     * @param \GEFOR\PlatformBundle\Entity\Candidat $candidat
     *
     * @return Formation
     */
    public function setCandidat(\GEFOR\PlatformBundle\Entity\Candidat $candidat)
    {
        $this->Candidat = $candidat;

        return $this;
    }

    /**
     * Get candidat
     *
     * @return \GEFOR\PlatformBundle\Entity\Candidat
     */
    public function getCandidat()
    {
        return $this->Candidat;
    }
}
