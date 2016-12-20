<?php

namespace InstitutionBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstitutionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de votre établissement'
            ])


            ->add('category', EntityType::class, [
                'class' => 'InstitutionBundle\Entity\Category',
                'label' => 'La catégorie de votre établissement'
            ])

            ->add('littleDescription', TextareaType::class, [
                'label' => 'Une petite description de votre établissement'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'La description de votre établissment'
            ])

            ->add('formattedPhoneNumber', TextType::class, [
                'label' => 'Numéro de téléphone de votre établissement'
            ])
            ->add('formattedInternationalPhoneNumber', TextType::class, [
                'label' => 'Numéro international téléphone de votre établissement'
            ])
            ->add('email', TextType::class, [
                'label' => 'Adresse email (non visible)'
            ])
            ->add('city', TextType::class, [
                'label' => 'La ville ou se situe votre établissement'
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Le code postale de votre ville'
            ])
            ->add('website', TextType::class, [
                'label' => 'Le site web de votre établissement (optionnel)'
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'InstitutionBundle\Entity\Institution'
        ));
    }
}
