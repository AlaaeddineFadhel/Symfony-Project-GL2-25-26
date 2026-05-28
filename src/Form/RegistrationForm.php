<?php

namespace App\Form;

use App\Entity\Insatien;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ── Champs Insatien (mapped=false, remplis manuellement dans le controller)
            ->add('prenom', TextType::class, [
                'mapped'      => false,
                'label'       => false,
                'attr'        => ['placeholder' => 'First name'],
                'constraints' => [new Assert\NotBlank(), new Assert\Length(max: 100)],
            ])
            ->add('nom', TextType::class, [
                'mapped'      => false,
                'label'       => false,
                'attr'        => ['placeholder' => 'Last name'],
                'constraints' => [new Assert\NotBlank(), new Assert\Length(max: 100)],
            ])
            // ── Champs User
            ->add('email', EmailType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Email'],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type'          => PasswordType::class,
                'mapped'        => false,
                'first_options' => [
                    'label' => false,
                    'attr'  => ['placeholder' => 'Password'],
                ],
                'second_options' => [
                    'label' => false,
                    'attr'  => ['placeholder' => 'Confirm Password'],
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(min: 8, minMessage: 'Password must be at least 8 characters.'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}