<?php

namespace App\Form;

use App\Entity\ContactMessages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactMessagesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Build grad year choices (newest first)
        $years = [];
        foreach (range(2031, 2017) as $y) {
            $years[(string)$y] = (string)$y;
        }
        $years['Before 2017']    = 'Before 2017';
        $years['Current Student'] = 'Current Student';

        $builder
            ->add('firstName', TextType::class, [
                'label'       => 'First Name',
                'attr'        => ['placeholder' => 'Jane', 'class' => 'form-control contact-input'],
                'constraints' => [
                    new Assert\NotBlank(message: 'First name is required.'),
                    new Assert\Length(max: 100),
                ],
            ])
            ->add('lastName', TextType::class, [
                'label'       => 'Last Name',
                'attr'        => ['placeholder' => 'Doe', 'class' => 'form-control contact-input'],
                'constraints' => [
                    new Assert\NotBlank(message: 'Last name is required.'),
                    new Assert\Length(max: 100),
                ],
            ])
            ->add('email', EmailType::class, [
                'label'       => 'Email Address',
                'attr'        => ['placeholder' => 'jane.doe@insat.tn', 'class' => 'form-control contact-input'],
                'constraints' => [
                    new Assert\NotBlank(message: 'Email is required.'),
                    new Assert\Email(message: 'Please enter a valid email address.'),
                ],
            ])
            ->add('gradYear', ChoiceType::class, [
                'label'       => 'Graduation Year',
                'required'    => false,
                'mapped'      => false,          // not in entity — stored in topic or ignored
                'placeholder' => 'Select year',
                'choices'     => $years,
                'attr'        => ['class' => 'form-select contact-input'],
            ])
            ->add('topic', ChoiceType::class, [
                'label'       => 'Topic',
                'required'    => false,
                'placeholder' => "What's this about?",
                'choices'     => [
                    'General Inquiry'           => 'General Inquiry',
                    'Report a Bug'              => 'Report a Bug',
                    'Partnership / Sponsorship' => 'Partnership / Sponsorship',
                    'Suggestion'                => 'Suggestion',
                    'Profile / Account Help'    => 'Profile / Account Help',
                    'Other'                     => 'Other',
                ],
                'attr' => ['class' => 'form-select contact-input'],
            ])
            ->add('message', TextareaType::class, [
                'label'       => 'Message',
                'attr'        => [
                    'rows'        => 5,
                    'placeholder' => "Tell us what's on your mind…",
                    'class'       => 'form-control contact-input',
                ],
                'constraints' => [
                    new Assert\NotBlank(message: 'Message is required.'),
                    new Assert\Length(min: 10, minMessage: 'Message must be at least 10 characters.'),
                ],
            ])
            ->add('newsletter', CheckboxType::class, [
                'label'    => 'Keep me updated on alumni news & events',
                'required' => false,
                'mapped'   => false,             // not in entity
                'attr'     => ['class' => 'form-check-input contact-check'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactMessages::class,
        ]);
    }
}