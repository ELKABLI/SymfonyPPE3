<?php

namespace GEFOR\PlatformBundle\Controller;

use GEFOR\PlatformBundle\Entity\Candidat;
use GEFOR\PlatformBundle\Form\CandidatType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\component\HttpFoundation\Request;


class InscriptionController extends Controller{

    public function home_viewAction(Request $request)
    {
        $candidat = new Candidat;

        $form = $this->get('form.factory')->create(CandidatType::class, $candidat);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($candidat);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirect($this->generateUrl('Inscription'));
        }

        return $this->render('GEFORPlatformBundle:Inscription:home_view.html.twig', array('form' => $form->createView(),));
       
        //Création de l'entité candidat
        /*
        $candidat = new Candidat();
        $candidat->setDate(new \DateTime("now"));
        $candidat->setPrenom('dupond');
        $candidat->setNom('jack');
        $candidat->setNeele(new \DateTime("now"));
        $candidat->setNationalite('france');
        $candidat->setNumerosecu(1234);
        $candidat->setAdresse('allée des');
        $candidat->setCp(02210);
        $candidat->setVille('dupond');
        $candidat->setTel(03000000);
        $candidat->setPortable(0600000);
        $candidat->setEmail('Duupond');
        $candidat->setFamille('Dubond');
    
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
        $em->flush();*/

    }

    public function adminAction()
    {

        //on récupére les repository
        $em = $this->getDoctrine()->getManager();

        //on récuper les entitées correspondates
        $entity = $em->getRepository('GEFORPlatformBundle:Candidat')->findAll();

        //il faut lier les candidats aux formations
        //$entity->addFormation();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Survey entity.');
        }

        $situations = $em->getRepository('GEFORPlatformBundle:Situation')->findAll();

        if (!$situations) {
            throw $this->createNotFoundException('Unable to find Survey entity.');
        }


        //on récupére les repository
        
        $em    = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('candidats, formation, situation') //ici on met les clefs primaires
            ->from('GEFORPlatformBundle:Candidat', 'candidats') //on donne un alias à l'entité Candidat
            ->join('candidats.formation', 'formation') // (attribut sur lequel on fait la jointure deouis Candidat, alias)
            ->join('candidats.situation', 'situation')
            ->where('formation.type = :type')
            ->setParameter(':type', 'CG');

        $filtre = $query
            ->getQuery()
            ->getResult();

        $em    = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
            ->select('formation, candidats') //ici on met les clefs primaires
            ->from('GEFORPlatformBundle:Formation', 'formation') //on donne un alias à l'entité Candidat
            ->join('formation.candidats', 'candidats'); // (attribut sur lequel on fait la jointure depuis Candidat, alias)

            

        $formations = $query
            ->getQuery()
            ->getResult();





        return $this->render('GEFORPlatformBundle:Inscription:admin.html.twig', array('entity' => $entity, 'situation' => $situations,'formation' => $formations, 'filtre' => $filtre));

    }

    public function menuAction($limit = 3)
    {
        //requette pour afficher les 3 derniers inscrit, à integrer dans le menu gauche.

        $list = $this->getDoctrine()->getManager()->getRepository('GEFORPlatformBundle:Candidat')->findBy(

            array(), // Pas de critère

            array('date' => 'desc'), // On trie par date décroissante

            $limit, // On sélectionne $limit annonces

            0// À partir du premier

        );

        return $this->render('GEFORPlatformBundle:Inscription:menu.html.twig', array('list' => $list));

    }

}

