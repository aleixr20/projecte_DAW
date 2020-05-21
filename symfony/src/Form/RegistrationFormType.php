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
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'El nom no pot ser inferior a {{ limit }} caràcters',
                        'max' => 40,
                        'maxMessage' => 'El nom no pot ser superior a {{ limit }} caràcters',
                    ])
                ]
            ])

            ->add('cognom', TextType::class, [
                'label' => 'Cognom *',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'El cognom no pot ser inferior a {{ limit }} caràcters',
                        'max' => 40,
                        'maxMessage' => 'El cognom no pot ser superior a {{ limit }} caràcters',
                    ])
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'help' => 'Adreça de correu electrònic on rebre la verificació del registre.',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'El mail no pot ser superior a {{ limit }} caràcters',
                    ])
                ]
            ])

            ->add('nom_usuari', TextType::class, [
                'label' => 'Nom d\'usuari *',
                'help' => 'Aques serà el teu nom públic. Ha de ser unic i de 8 a 14 caràcters.',
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
                'help' => 'Tria una contrasenya de minim 8 caracters que contingui lletres minuscules, majuscules i algun numeros',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'La contrasenya ha de ser sminim de {{ limit }} caràcters',
                        'max' => 50,
                        'maxMessage' => 'La contrasenya no pot ser superior a {{ limit }} caràcters',
                    ]),
                ],
                'mapped' => false,
            ])

            ->add('pass2', PasswordType::class, [
                'label' => 'Repetir contrasenya *',
                'help' => 'Torna a escriure la contrasenya i asegurat que la mateixa',
                'attr' => ['class' => 'form-control'],
                'mapped' => false
            ])

            ->add('data_naixament', BirthdayType::class, [
                'label' => 'Data de naixement',
                'help' => 'Aquest camp es opcional. ',
                'attr' => ['class' => 'form-control'],
                'placeholder' => [
                    'day' => 'Dia',
                    'month' => 'Mes',
                    'year' => 'Any',
                ],
                'format' => 'dd  MM  yyyy',
                'required' => false,
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
