<?php

namespace GEFOR\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SituationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array('choices' => array("CDI" => "CDI", "CDD" => "CDD", "En recherche d\' emploie" => "En recherche d\' emploie")))
            
            //->add('langue', TextType::class)
            //->add('informatique', TextType::class)
            //->add('motivation', TextareaType::class)         
        ;
    }

     public function buildNew(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class);
            
            //->add('langue', TextType::class)
            //->add('informatique', TextType::class)
            //->add('motivation', TextareaType::class)         
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GEFOR\PlatformBundle\Entity\Situation'
        ));
    }

     /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gefor_platformbundle_situation';
    }
}