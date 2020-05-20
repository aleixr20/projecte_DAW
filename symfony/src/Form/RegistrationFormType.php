<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom *',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('cognom', TextType::class, [
                'label' => 'Cognom *',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('nom_usuari', TextType::class, [
                'label' => 'Nom d\'usuari *',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'El nom d\'usuari no pot ser inferior a {{ limit }} caràcters',
                        'max' => 14,
                        'maxMessage' => 'El nom d\'usuari no pot ser superior a {{ limit }} caràcters',
                    ])
                ]
            ])

            ->add('plainPassword', PasswordType::class, [
                'label' => 'Contrasenya *',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'mapped' => false,
            ])

            ->add('pass2', PasswordType::class, [
                'label' => 'Repetir contrasenya *',
                'attr' => ['class' => 'form-control'],
                'mapped' => false
            ])

            ->add('data_naixament', BirthdayType::class, [
                'required' => false,
                'placeholder' => [
                    'day' => 'Dia',
                    'month' => 'Mes',
                    'year' => 'Any',
                ],
                'format' => 'dd  MM  yyyy'
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "Has d'acceptar els termes i condicions.",
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
