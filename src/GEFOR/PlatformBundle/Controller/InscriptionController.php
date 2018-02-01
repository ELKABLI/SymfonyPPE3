<?php

namespace GEFOR\PlatformBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use GEFOR\PlatformBundle\Entity\Candidat;
use GEFOR\PlatformBundle\Form\CandidatType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InscriptionController extends Controller
{

    public function indexAction(Request $request)
    {
        $candidat = new Candidat;
        $candidat->setDate(new \Datetime());
        $form = $this->get('form.factory')->create(CandidatType::class, $candidat);

        $validator  = $this->get('validator');
        $listErrors = $validator->validate($candidat);

        //exit(); // ne trouve pas d'erreur a revoir !!!!!
        /*
        if(count($listErrors) > 0){
        echo ("annonce non valide");
        //return new Response((string) $listErrors);
        }else{
        echo ("annonce valide maintenant!");
        // return new Response("l'annonce est valide !");
        }*/

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($candidat);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirectToRoute('Inscription_new', array('id' => $candidat->getId(), 'sms' => $request)); // on transmet au controlleur newAction l'annonce unique caractérisé par son id du new candidat, new action récuper cette objet et le transmet a sa vu.
        }

       

        return $this->render('GEFORPlatformBundle:Inscription:index.html.twig', array('form' => $form->createView(), 'listErrors' => $listErrors));

    }

    public function newAction(Candidat $candidat)
    {

        return $this->render('GEFORPlatformBundle:Inscription:new.html.twig', array('candidat' => $candidat));

    }

    public function adminAction()
    {

        //on récupére les repository
        $em = $this->getDoctrine()->getManager();

        //on récuper les entitées correspondates
        $candidat = $em->getRepository('GEFORPlatformBundle:Candidat')->findAll();

        //il faut lier les candidats aux formations
        //$entity->addFormation();

        if (!$candidat) {
            throw $this->createNotFoundException('Unable to find Survey entity.');
        }

        $situations = $em->getRepository('GEFORPlatformBundle:Situation')->findAll();

        if (!$situations) {
            throw $this->createNotFoundException('Unable to find Survey entity.');
        }

        //on récupére les repository

        /*
        $query = $em->createQueryBuilder()
        ->select('candidats, formation, situation') //ici on met les clefs primaires
        ->from('GEFORPlatformBundle:Candidat', 'candidats') //on donne un alias à l'entité Candidat
        ->join('candidats.formation', 'formation') // (attribut sur lequel on fait la jointure deouis Candidat, alias)
        ->join('candidats.situation', 'situation')
        ->where('formation.type = :type')
        ->setParameter(':type', 'CG');

        $filtre = $query
        ->getQuery()
        ->getResult();*/

        $nbcandidats = count($candidat);

        $contact = $em->getRepository('GEFORPlatformBundle:Candidat')->findBycontact('Oui');


        $contactarray = array();
        foreach ($contact as $value) {
            $contactarray[] = [$value->getid(), $value->getnom(), $value->getprenom(), $value->getdate()->format('d-m-Y')];
        }

       
        //hai : ajout de getdat() et convertion pour affichage dans twig


        $query = $em->createQueryBuilder()
            ->select('formation, candidats') //ici on met les clefs primaires
            ->from('GEFORPlatformBundle:Formation', 'formation') //on donne un alias à l'entité Candidat

            ->join('formation.candidats', 'candidats'); // (attribut sur lequel on fait la jointure depuis Candidat, alias)

        $formations = $query
            ->getQuery()
            ->getResult();
        //Voir avec hai pour avoir tableau Diplome => candidats

        $testarray      = array();
        $candidatsarray = array();
        foreach ($formations as $key => $value) {
            $testarray[$value->getType()] = $value->getCandidats()->count();
        }

        $query = $em->createQueryBuilder()
            ->select('situation, candidats') //ici on met les clefs primaires
            ->from('GEFORPlatformBundle:Situation', 'situation') //on donne un alias à l'entité Candidat

            ->join('situation.candidats', 'candidats'); // (attribut sur lequel on fait la jointure depuis Candidat, alias)

        $situation = $query
            ->getQuery()
            ->getResult();

        $situationarray = array();
        foreach ($situation as $key => $value) {
            $situationarray[$value->getType()] = $value->getCandidats()->count();
        }

        /*
        $testarray = array();
        $candidatsarray = array();
        foreach ($formations as $key => $value) {
        $testarray[$value -> getType()] = [$value -> getCandidats() -> count(),$value -> getCandidats() -> getSituation()];
        }
        dump($testarray);
        dump($formations); exit;*/

//requette pour la récuperation de données pour les graph fonction des type de Projet (Bts SLAM SISR BANQUE)
        $query = $em->createQueryBuilder()
            ->select('candidats, formation') //ici on met les clefs primaires
            ->from('GEFORPlatformBundle:Candidat', 'candidats') //on donne un alias à l'entité Formation

            ->join('candidats.formation', 'formation') // (on joint formation et candidats)
            ->where('formation.type = :type')
            ->setParameter(':type', 'BTS SIO SLAM');

        $typesio = $query
            ->getQuery()
            ->getResult();

        $query = $em->createQueryBuilder()
            ->select('candidats, formation') //ici on met les clefs primaires
            ->from('GEFORPlatformBundle:Candidat', 'candidats') //on donne un alias à l'entité Formation

            ->join('candidats.formation', 'formation') // (on joint formation et candidats)
            ->where('formation.type = :type')
            ->setParameter(':type', 'BTS SIO SISR');

        $typesisr = $query
            ->getQuery()
            ->getResult();

        $query = $em->createQueryBuilder()
            ->select('candidats, formation') //ici on met les clefs primaires
            ->from('GEFORPlatformBundle:Candidat', 'candidats') //on donne un alias à l'entité Formation

            ->join('candidats.formation', 'formation') // (on joint formation et candidats)
            ->where('formation.type = :type')
            ->setParameter(':type', 'BTS BANQUE');

//requette pour la récuperation de données pour les graph fonction des type de situation (CIF CDI CDD)

        $typebanque = $query
            ->getQuery()
            ->getResult();

        $query = $em->createQueryBuilder()
            ->select('candidats, situation') //ici on met les clefs primaires
            ->from('GEFORPlatformBundle:Candidat', 'candidats') //on donne un alias à l'entité Formation

            ->join('candidats.situation', 'situation') // (on joint formation et candidats)
            ->where('situation.type = :type')
            ->setParameter(':type', 'CDI');

        $situationcdi = $query
            ->getQuery()
            ->getResult();

        $query = $em->createQueryBuilder()
            ->select('candidats, situation') //ici on met les clefs primaires
            ->from('GEFORPlatformBundle:Candidat', 'candidats') //on donne un alias à l'entité Formation

            ->join('candidats.situation', 'situation') // (on joint formation et candidats)
            ->where('situation.type = :type')
            ->setParameter(':type', 'CDD');

        $situationcdd = $query
            ->getQuery()
            ->getResult();

        $query = $em->createQueryBuilder()
            ->select('candidats, situation') //ici on met les clefs primaires
            ->from('GEFORPlatformBundle:Candidat', 'candidats') //on donne un alias à l'entité Formation

            ->join('candidats.situation', 'situation') // (on joint formation et candidats)
            ->where('situation.type = :type')
            ->setParameter(':type', "Demandeur d'emploi");

        $situationpe = $query
            ->getQuery()
            ->getResult();

// les 2 premiers graph sur le tabelau générale

        $pieChartg1 = new PieChart();
        $pieChartg1->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['BTS SIO SLAM', count($typesio)],
                ['BTS SIO SISR', count($typesisr)],
                ['BTS BANQUE', count($typebanque)],
            ]
        );
        $pieChartg1 = $this->optiongraph($pieChartg1);
        $pieChartg1->getOptions()->setTitle('Projets souhaités');
        $pieChartg1->getOptions()->setHeight(300);
        $pieChartg1->getOptions()->setWidth(400);

        $pieChartg2 = new PieChart();
        $pieChartg2->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['CDI', count($situationcdi)],
                ['CDD', count($situationcdd)],
                ["Demandeur d'emploi", count($situationpe)],
            ]
        );
        $pieChartg2 = $this->optiongraph($pieChartg2);
        $pieChartg2->getOptions()->setTitle('Situation des candidats');
        $pieChartg2->getOptions()->setHeight(300);
        $pieChartg2->getOptions()->setWidth(400);

        //requette pour la récuperation de données pour les graph par Projet situation et age(Bts SLAM SISR BANQUE)

        $query = $em->createQueryBuilder()
            ->select('candidats, formation, situation')
            ->from('GEFORPlatformBundle:Candidat', 'candidats')
            ->join('candidats.formation', 'formation')
            ->join('candidats.situation', 'situation')
            ->where('formation.type = :forma')
            ->andwhere('situation.type = :situ')
            ->setParameter(':forma', 'BTS SIO SLAM')
            ->setParameter(':situ', 'CDI');

        $slam_cdi = $query
            ->getQuery()
            ->getResult();

        $query = $em->createQueryBuilder()
            ->select('candidats, formation, situation')
            ->from('GEFORPlatformBundle:Candidat', 'candidats')
            ->join('candidats.formation', 'formation')
            ->join('candidats.situation', 'situation')
            ->where('formation.type = :forma')
            ->andwhere('situation.type = :situ')
            ->setParameter(':forma', 'BTS SIO SLAM')
            ->setParameter(':situ', 'CDD');

        $slam_cdd = $query
            ->getQuery()
            ->getResult();

        $query = $em->createQueryBuilder()
            ->select('candidats, formation, situation')
            ->from('GEFORPlatformBundle:Candidat', 'candidats')
            ->join('candidats.formation', 'formation')
            ->join('candidats.situation', 'situation')
            ->where('formation.type = :forma')
            ->andwhere('situation.type = :situ')
            ->setParameter(':forma', 'BTS SIO SLAM')
            ->setParameter(':situ', "Demandeur d'emploi");

        $slam_pe = $query
            ->getQuery()
            ->getResult();

        $pieChart[2] = new PieChart();
        $pieChart[2]->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['CDI', count($slam_cdi)],
                ['CDD', count($slam_cdd)],
                ["Demandeur d'emploi", count($slam_pe)],
            ]
        );
        $pieChart[2] = $this->optiongraph($pieChart[2]);
        $pieChart[2]->getOptions()->setTitle('Situation des slam');

        $query = $em->createQueryBuilder()
            ->select('candidats, formation, situation')
            ->from('GEFORPlatformBundle:Candidat', 'candidats')
            ->join('candidats.formation', 'formation')
            ->join('candidats.situation', 'situation')
            ->where('formation.type = :forma')
            ->andwhere('situation.type = :situ')
            ->setParameter(':forma', 'BTS SIO SISR')
            ->setParameter(':situ', 'CDI');

        $sisr_cdi = $query
            ->getQuery()
            ->getResult();

        $query = $em->createQueryBuilder()
            ->select('candidats, formation, situation')
            ->from('GEFORPlatformBundle:Candidat', 'candidats')
            ->join('candidats.formation', 'formation')
            ->join('candidats.situation', 'situation')
            ->where('formation.type = :forma')
            ->andwhere('situation.type = :situ')
            ->setParameter(':forma', 'BTS SIO SISR')
            ->setParameter(':situ', 'CDD');

        $sisr_cdd = $query
            ->getQuery()
            ->getResult();

        $query = $em->createQueryBuilder()
            ->select('candidats, formation, situation')
            ->from('GEFORPlatformBundle:Candidat', 'candidats')
            ->join('candidats.formation', 'formation')
            ->join('candidats.situation', 'situation')
            ->where('formation.type = :forma')
            ->andwhere('situation.type = :situ')
            ->setParameter(':forma', 'BTS SIO SISR')
            ->setParameter(':situ', "Demandeur d'emploi");

        $sisr_pe = $query
            ->getQuery()
            ->getResult();

        $pieChart[1] = new PieChart();
        $pieChart[1]->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['CDI', count($sisr_cdi)],
                ['CDD', count($sisr_cdd)],
                ["Demandeur d'emploi", count($sisr_pe)],
            ]
        );
        $pieChart[1] = $this->optiongraph($pieChart[1]);
        $pieChart[1]->getOptions()->setTitle('Situation des sisr');

//banque stat

        $query = $em->createQueryBuilder()
            ->select('candidats, formation, situation')
            ->from('GEFORPlatformBundle:Candidat', 'candidats')
            ->join('candidats.formation', 'formation')
            ->join('candidats.situation', 'situation')
            ->where('formation.type = :forma')
            ->andwhere('situation.type = :situ')
            ->setParameter(':forma', 'BTS BANQUE')
            ->setParameter(':situ', 'CDI');

        $banque_cdi = $query
            ->getQuery()
            ->getResult();

        $query = $em->createQueryBuilder()
            ->select('candidats, formation, situation')
            ->from('GEFORPlatformBundle:Candidat', 'candidats')
            ->join('candidats.formation', 'formation')
            ->join('candidats.situation', 'situation')
            ->where('formation.type = :forma')
            ->andwhere('situation.type = :situ')
            ->setParameter(':forma', 'BTS BANQUE')
            ->setParameter(':situ', 'CDD');

        $banque_cdd = $query
            ->getQuery()
            ->getResult();

        $query = $em->createQueryBuilder()
            ->select('candidats, formation, situation')
            ->from('GEFORPlatformBundle:Candidat', 'candidats')
            ->join('candidats.formation', 'formation')
            ->join('candidats.situation', 'situation')
            ->where('formation.type = :forma')
            ->andwhere('situation.type = :situ')
            ->setParameter(':forma', 'BTS BANQUE')
            ->setParameter(':situ', "Demandeur d'emploi");

        $banque_pe = $query
            ->getQuery()
            ->getResult();

        $pieChart[3] = new PieChart();
        $pieChart[3]->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['CDI', count($banque_cdi)],
                ['CDD', count($banque_cdd)],
                ["Demandeur d'emploi", count($banque_pe)],
            ]

        );

        /*dump($banque_cdi);
        dump($banque_cdd);
        dump($banque_pe);
        exit;*/


        $pieChart[3] = $this->optiongraph($pieChart[3]);
        $pieChart[3]->getOptions()->setTitle('Situation des banques');

        
        return $this->render('GEFORPlatformBundle:Inscription:admin.html.twig', array('candidat' => $candidat, 'situation' => $situations, 'formation' => $formations, 'piechartg1' => $pieChartg1, 'piechartg2' => $pieChartg2, 'piechart' => $pieChart, 'nbcandidat' => $testarray, 'nbsituation' => $situationarray, 'nbcandidats' => $nbcandidats, 'contactarray' => $contactarray));

        //pas necessaire return $this->redirectToRoute('Inscription_show', array('candidat' => $candidat)); // on transmet au controlleur showAction les candidats, showAction récuper ces objets et les transmets a sa vu.

    }

    public function statsAction()
    {

        $em = $this->getDoctrine()->getManager();
        //on récuper les entitées correspondates
        $candidat = $em->getRepository('GEFORPlatformBundle:Candidat')->findAll();
        $nbcandidats = count($candidat);
        
        $query = $em->createQueryBuilder()
            ->select('formation, candidats')
            ->from('GEFORPlatformBundle:Formation', 'formation')
            ->join('formation.candidats', 'candidats');

        $formations = $query
            ->getQuery()
            ->getResult();
        //Voir avec hai pour avoir tableau Diplome => candidats
        $testarray      = array();
        $candidatsarray = array();
        foreach ($formations as $key => $value) {
            $testarray[$value->getType()] = $value->getCandidats()->count();}



         $datastatsfor = array();
         $datastatsfor[] = ['Task', 'Hours per Day'];
        foreach ($formations as $key => $value) {
            $datastatsfor[] = [$value->getType(), $value->getCandidats()->count()];
        }



        $query = $em->createQueryBuilder()
            ->select('situation, candidats') //ici on met les clefs primaires
            ->from('GEFORPlatformBundle:Situation', 'situation') //on donne un alias à l'entité Candidat
            ->join('situation.candidats', 'candidats'); // (attribut sur lequel on fait la jointure depuis Candidat, alias)

        $situation = $query
            ->getQuery()
            ->getResult();

        $situationarray = array();
        foreach ($situation as $key => $value) {
            $situationarray[$value->getType()] = $value->getCandidats()->count();
        }
        /*
        dump($situationarray);
        dump($situation);exit;*/

        $datastatssitu = array();
         $datastatssitu[] = ['Task', 'Hours per Day'];
        foreach ($situation as $key => $value) {
            $datastatssitu[] = [$value->getType(), $value->getCandidats()->count()];
        }

        // stat répartition du financement
         $query = $em->createQueryBuilder()
            ->select('financement, candidats') //ici on met les clefs primaires
            ->from('GEFORPlatformBundle:Financement', 'financement') //on donne un alias à l'entité Candidat
            ->join('financement.candidats', 'candidats'); // (attribut sur lequel on fait la jointure depuis Candidat, alias)

        $financement = $query
            ->getQuery()
            ->getResult();
        
        $financementarray = array();
        foreach ($financement as $key => $value) {
            $financementarray[$value->getType()] = $value->getCandidats()->count();
        }
        $datastatsfinan = array();
         $datastatsfinan[] = ['Task', 'Hours per Day'];
        foreach ($financement as $key => $value) {
            $datastatsfinan[] = [$value->getType(), $value->getCandidats()->count()];
        }

        /*
        dump($financementarray);
        dump($financement);exit;*/
        //fin stats répartition du financement 

       
        $pieChartstats1 = new PieChart();
        $pieChartstats1->getData()->setArrayToDataTable($datastatssitu);
        $pieChartstats1 = $this->optiongraph($pieChartstats1);
        $pieChartstats1->getOptions()->setTitle('Situation des candidats');

        $pieChartstats2 = new PieChart();
        $pieChartstats2->getData()->setArrayToDataTable($datastatsfor);
        $pieChartstats2 = $this->optiongraph($pieChartstats2);
        $pieChartstats2->getOptions()->setTitle('Répartition des candidats par diplôme');


        $pieChartstats3 = new PieChart();
        $pieChartstats3->getData()->setArrayToDataTable($datastatsfinan);
        $pieChartstats3 = $this->optiongraph($pieChartstats3);
        $pieChartstats3->getOptions()->setTitle('Répartition des candidats par financement');



        return $this->render('GEFORPlatformBundle:Inscription:stats.html.twig', array('candidat' => $candidat, 'nbcandidat' => $testarray, 'nbsituation' => $situationarray, 'nbcandidats' => $nbcandidats, 'nbfinancement'=>$financementarray, 'pieChartstats1' => $pieChartstats1, 'pieChartstats2' => $pieChartstats2, 'pieChartstats3' => $pieChartstats3 ));

    }

    public function editAction(Request $request, Candidat $candidat)
    {
        $deleteForm = $this->createDeleteForm($candidat);
        $editForm   = $this->createForm('GEFOR\PlatformBundle\Form\CandidatType', $candidat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Inscription_edit', array('id' => $candidat->getId()));
        }

        return $this->render('GEFORPlatformBundle:Inscription:edit.html.twig', array(
            'candidat'    => $candidat,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function showAction(Candidat $candidat)
    {

        $deleteForm = $this->createDeleteForm($candidat);

        return $this->render('GEFORPlatformBundle:Inscription:show.html.twig', array(
            'candidat'    => $candidat,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    private function createDeleteForm(Candidat $candidat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Inscription_delete', array('id' => $candidat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function deleteAction(Request $request, Candidat $candidat)
    {
        $form = $this->createDeleteForm($candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($candidat);
            $em->flush();
        }

        return $this->redirectToRoute('Admin');
    }

    private function optiongraph($option)
    {

        $option->getOptions()->setIs3D(true);
        $option->getOptions()->setHeight(300);
        $option->getOptions()->setBackgroundColor('#cacfd2');
        $option->getOptions()->getTitleTextStyle()->setBold(true);
        $option->getOptions()->getTitleTextStyle()->setColor('#009900');
        $option->getOptions()->getTitleTextStyle()->setItalic(true);
        $option->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $option->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $option;
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
