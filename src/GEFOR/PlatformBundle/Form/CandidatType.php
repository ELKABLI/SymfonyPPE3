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

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CandidatType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateTimeType::class)
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('neele', DateType::class, array('label'=>'Date de naissance'))
            ->add('nationalite', TextType::class)
            //->add('numerosecu', IntegerType::class)
            ->add('adresse', TextType::class)
            ->add('cp', IntegerType::class)
            ->add('ville', TextType::class)
            ->add('tel', IntegerType::class)
            ->add('portable',IntegerType::class)
            ->add('email',TextType::class)
            ->add('famille',TextType::class)
            ->add('situation',SituationType::class)
            ->add('formation',EntityType::class, array(
                'class' => 'GEFOR\PlatformBundle\Entity\Formation',
                'choice_label' => 'type'
            ))

            ->add('agenda',AgendaType::class)
            /*->add('agenda',EntityType::class, array(
                'class' => 'GEFOR\PlatformBundle\Entity\Agenda',
                'choice_label' => 'date'
            ))*/



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
