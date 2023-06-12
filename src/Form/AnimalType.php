<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Specie;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('specie', EntityType::class,
        [
            // looks for choices from this entity
            'class' => Specie::class,
            'label' => 'Espèce :',
            'choice_label' => 'name',
            'required' => true
        ])
        ->add('breed', TextType::class,
        [
            'attr'=>['class'=>'form'],
            'label' => 'Race',
            'required' => true
        ])
        ->add('dob', DateType::class,
        [
            'attr'=>['class'=>'form'],
            'label' => 'Date de naissance',
            'widget' => 'single_text',
            'required' => true
        ])
        ->add('name', TextType::class,
        [
            'attr'=>['class'=>'form'],
            'label' => 'Nom',
            'required' => true
        ])
        ->add('gender', ChoiceType::class,
        [
            'choices'  => [
                'Femelle' => true,
                'Mâle' => false,
            ],
            'attr'=>['class'=>'form'],
            'label' => 'Sexe',
            'required' => true
        ])
        ->add('color', TextType::class,
        [
            'attr'=>['class'=>'form'],
            'label' => 'Couleur du pelage (non obligatoire)',
            'required' => false
        ])
        ->add('idChip', NumberType::class,
        [
            'attr'=>['class'=>'form'],
            'label' => 'Numero de puce (non obligatoire)',
            'required' => false
        ])
        ->add('sterelisation', ChoiceType::class,
        [
            'choices'  => [
                'Oui' => true,
                'Non' => false,
            ],
            'attr'=>['class'=>'form'],
            'label' => 'Animal stérélisé? (non obligatoire)',
            'required' => false
        ])
        ->add('weight', NumberType::class,
        [
            'attr'=>['class'=>'form'],
            'label' => 'Poids (non obligatoire)',
            'required' => false
        ])
        ->add('medicalHistory', TextType::class,
        [
            'attr'=>['class'=>'form'],
            'label' => 'Historique médical important (non obligatoire)',
            'required' => false
        ])
        ->add('Inscription', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
