<?php

namespace App\Form;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Veuillez saisir un nom'])
            ],
            'required' => true, // Rendre le champ obligatoire
      
        ])
        ->add('date', DateType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Veuillez saisir une date']),
                new GreaterThanOrEqual([
                    'value' => 'today',
                    'message' => 'La date ne peut pas être antérieure à aujourd\'hui.'
                ])
            ],
            'required' => true,

        ])
        ->add('locationX', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Veuillez saisir une latitude'])
            ],
            'required' => true
        ])
        ->add('locationY', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Veuillez saisir une longitude'])
            ],
            'required' => true
        ])
        ->add('ville', TextType::class, [
            'constraints' => [
                new NotBlank(['message' => 'Veuillez saisir une ville'])
            ],
            'required' => true
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
