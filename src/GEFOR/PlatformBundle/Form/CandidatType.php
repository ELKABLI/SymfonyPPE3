<?php

namespace GEFOR\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;




class CandidatType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('date', DateTimeType::class)
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('neele', DateType::class, array('label'=>'Date de naissance'))
            ->add('nationalite', CountryType::class)
            //->add('numerosecu', IntegerType::class)
            ->add('adresse', TextType::class)
            ->add('cp', IntegerType::class)
            ->add('ville', TextType::class)
            ->add('tel', TextType::class, array('label'=>'Téléphone fixe'))
            ->add('portable',TextType::class, array('required' => false))
            ->add('email',TextType::class)
            ->add('famille',ChoiceType::class, array('choices'=> array(
                'Marié','paqusé','célibataire'), 'label'=>'Situation familliale'))
            ->add('motivation',TextareaType::class)
            ->add('contact',ChoiceType::class, array('choices'=> array(
                'Non' => 'Non','Oui' => 'Oui'),'label'=>'Désirez vous un RDV ?'))
            ->add('situation',EntityType::class, array(
                'class' => 'GEFOR\PlatformBundle\Entity\Situation',
                'choice_label' => 'type',
                'label_format' => 'Quelle est votre situation professionelle actuelle ?'
            ))
            ->add('formation',EntityType::class, array(
                'class' => 'GEFOR\PlatformBundle\Entity\Formation',
                'choice_label' => 'type',
                'label_format' => 'Quelle formation souhaitez vous réaliser ?'
            ))

            ->add('financement',EntityType::class, array(
                'class' => 'GEFOR\PlatformBundle\Entity\Financement',
                'choice_label' => 'type',
                'label_format' => 'Comment comptez vous financer votre projet ?'
            ))



            /*->add('formations', CollectionType::class,
                array('entry_type' => FormationType::class)
            ) */
            ->add('save', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GEFOR\PlatformBundle\Entity\Candidat'
        ));
    }
}
