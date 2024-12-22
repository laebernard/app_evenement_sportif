<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir un nom'])
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir un email'])
                ]
            ])
            ->add('locationX', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir une latitude'])
                ]
            ])
            ->add('locationY', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir une longitude'])
                ]
            ])
            ->add('ville', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir une ville'])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
