<?php

namespace InstitutionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstitutionCodeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de votre établissement',
                'required' => true
            ])
            ->add('formattedPhoneNumber', TextType::class, [
                'label' => 'Numéro de téléphone de votre établissement',
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'required' => true
            ])
            ->add('website', TextType::class, [
                'label' => 'Adresse internet de votre établissement (Optionnel)',
                'required' => false
            ])
            ->add('managerName', TextType::class, [
                'label' => 'Nom et Prénom du gérant',
                'required' => true
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
