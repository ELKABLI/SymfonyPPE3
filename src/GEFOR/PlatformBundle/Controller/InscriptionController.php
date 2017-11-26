<?php

namespace GEFOR\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GEFOR\PlatformBundle\Entity\Candidat;
use GEFOR\PlatformBundle\Entity\Formation;
use GEFOR\PlatformBundle\Entity\Situation;
use Symfony\component\HttpFoundation\Request;

class InscriptionController extends Controller
{
    public function home_viewAction()
    {
    	//Création de l'entité candidat
    	$candidat = new Candidat();
    	$candidat->setDate(new \DateTime("now"));
    	$candidat->setPrenom('ali');
    	$candidat->setNom('el kabli');
    	$candidat->setNeele(new \DateTime("now"));
    	$candidat->setNationalite('france');
    	$candidat->setNumerosecu(1234);
    	$candidat->setAdresse('allée des');
    	$candidat->setCp(02210);
    	$candidat->setVille('ali');
    	$candidat->setTel(03000000);
    	$candidat->setPortable(0600000);
    	$candidat->setEmail('ali');
    	$candidat->setFamille('ali');

    	//Création de l'entité formation
    	$formation=new Formation();
    	$formation->setType('bts SIO');

    	//Création de l'entité 
    	$situation=new Situation();
    	$situation->setType('marié');
    	$situation->setFinance('cif');
    	$situation->setLangue('marié');
    	$situation->setInformatique('marié');
    	$situation->setMotivation('marié');

    	// on lie formation et situation au candidat
    	$formation->setCandidat($candidat);
    	$situation->setCandidat($candidat);

    	//on recupére le gestionnaire d'entités
    	$em = $this->getDoctrine()->getManager();
    	// 1) persistance de l'entité
    	$em->persist($candidat);
    	$em->persist($formation);
    	$em->persist($situation);
    	$em->flush();


        return $this->render('GEFORPlatformBundle:Inscription:home_view.html.twig');
    }

    public function __construct()
    {
    	//par defaut la date de l'annonce est la date d'haujourduit
    	$this->date=new \Datetime();
    }


}
