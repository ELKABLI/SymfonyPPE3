<?php

namespace GEFOR\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidat
 *
 * @ORM\Table(name="candidat")
 * @ORM\Entity(repositoryClass="GEFOR\PlatformBundle\Repository\CandidatRepository")
 */
class Candidat
{
    /**
     * @ORM\ManyToOne(targetEntity="GEFOR\PlatformBundle\Entity\Agenda", inversedBy="candidats", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $agenda;


    /**
     * @ORM\ManyToOne(targetEntity="GEFOR\PlatformBundle\Entity\Formation", inversedBy="candidats", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $formation;

    /**
     * @ORM\ManyToOne(targetEntity="GEFOR\PlatformBundle\Entity\Situation", inversedBy="candidats", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $situation;

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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \Date
     *
     * @ORM\Column(name="neele", type="date")
     */
    private $neele;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=255)
     */
    private $nationalite;

    /**
     * @var int
     *
     * @ORM\Column(name="numerosecu", type="integer", nullable = true)
     * 
     */
    private $numerosecu;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var int
     *
     * @ORM\Column(name="cp", type="integer")
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer")
     */
    private $tel;

    /**
     * @var int
     *
     * @ORM\Column(name="portable", type="integer")
     */
    private $portable;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="famille", type="string", length=255)
     */
    private $famille;

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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Candidat
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Candidat
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set neele
     *
     * @param \DateTime $neele
     *
     * @return Candidat
     */
    public function setNeele($neele)
    {
        $this->neele = $neele;

        return $this;
    }

    /**
     * Get neele
     *
     * @return \DateTime
     */
    public function getNeele()
    {
        return $this->neele;
    }

    /**
     * Set nationalite
     *
     * @param string $nationalite
     *
     * @return Candidat
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set numerosecu
     *
     * @param integer $numerosecu
     *
     * @return Candidat
     */
    public function setNumerosecu($numerosecu)
    {
        $this->numerosecu = $numerosecu;

        return $this;
    }

    /**
     * Get numerosecu
     *
     * @return int
     */
    public function getNumerosecu()
    {
        return $this->numerosecu;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Candidat
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     *
     * @return Candidat
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return int
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Candidat
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     *
     * @return Candidat
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set portable
     *
     * @param integer $portable
     *
     * @return Candidat
     */
    public function setPortable($portable)
    {
        $this->portable = $portable;

        return $this;
    }

    /**
     * Get portable
     *
     * @return int
     */
    public function getPortable()
    {
        return $this->portable;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Candidat
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set famille
     *
     * @param string $famille
     *
     * @return Candidat
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return string
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set date
     *
     * @param integer $date
     *
     * @return Candidat
     */
    public function setDate(\Datetime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }



    /**
     * Set formation
     *
     * @param \GEFOR\PlatformBundle\Entity\Formation $formation
     *
     * @return Candidat
     */
    public function setFormation(\GEFOR\PlatformBundle\Entity\Formation $formation)
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * Get formation
     *
     * @return \GEFOR\PlatformBundle\Entity\Formation
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * Set situation
     *
     * @param \GEFOR\PlatformBundle\Entity\Situation $situation
     *
     * @return Candidat
     */
    public function setSituation(\GEFOR\PlatformBundle\Entity\Situation $situation)
    {
        $this->situation = $situation;

        return $this;
    }

    /**
     * Get situation
     *
     * @return \GEFOR\PlatformBundle\Entity\Situation
     */
    public function getSituation()
    {
        return $this->situation;
    }

    /**
     * Set agenda
     *
     * @param \GEFOR\PlatformBundle\Entity\Agenda $agenda
     *
     * @return Candidat
     */
    public function setAgenda(\GEFOR\PlatformBundle\Entity\Agenda $agenda)
    {
        $this->agenda = $agenda;

        return $this;
    }

    /**
     * Get agenda
     *
     * @return \GEFOR\PlatformBundle\Entity\Agenda
     */
    public function getAgenda()
    {
        return $this->agenda;
    }
}
