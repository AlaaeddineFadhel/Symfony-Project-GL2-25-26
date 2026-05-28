<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType as SearchInputType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', SearchInputType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control me-2',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Search',
                'attr' => [
                    'class' => 'btn btn-outline-success',

                ],
            ])
            ->add('filter', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'choices' => [
                    'Filter By' => 'all',
                    'Promo' => 'promo',
                    'Skills' => 'skills',
                    'Filière' => 'filiere',
                    'Parcours' => 'parcours',
                ],
                'attr' => [
                    'class' => 'form-select w-100',
                    'id' => 'filter_dropdown',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
