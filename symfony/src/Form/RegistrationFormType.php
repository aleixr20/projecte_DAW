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
                'label' => 'Nombre *',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'El nom no puede ser inferior a {{ limit }} caracteres',
                        'max' => 40,
                        'maxMessage' => 'El nom no puede ser superior a {{ limit }} caracteres',
                    ])
                ]
            ])

            ->add('cognom', TextType::class, [
                'label' => 'Apellido *',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'El apellido no puede ser inferior a {{ limit }} caracteres',
                        'max' => 40,
                        'maxMessage' => 'El apellido no puede ser superior a {{ limit }} caracteres',
                    ])
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'help' => 'Dirección de correo electrónico donde recibir la verificación del registro.',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'El mail no puede ser superior a {{ limit }} caracteres',
                    ])
                ]
            ])

            ->add('nom_usuari', TextType::class, [
                'label' => 'Nombre de usuario *',
                'help' => 'Este será tu nombre público. Debe de ser único y de 8 a 14 caracteres.',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'El nombre de usuario no puede ser inferior a {{ limit }} caracteres',
                        'max' => 14,
                        'maxMessage' => 'El nombre de usuario no puede ser superior a {{ limit }} caracteres',
                    ])
                ]
            ])

            ->add('plainPassword', PasswordType::class, [
                'label' => 'Contraseña *',
                'help' => 'Elige una contraseña de mínimo 8 caracteres y que contenga letras minúsculas, mayúsculas y algún número',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, introduzca una contraseña',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'La contraseña debe de ser mínimo de {{ limit }} caracteres',
                        'max' => 50,
                        'maxMessage' => 'La contraseña no debe de ser superior a {{ limit }} caracteres',
                    ]),
                ],
                'mapped' => false,
            ])

            ->add('pass2', PasswordType::class, [
                'label' => 'Repetir contraseña *',
                'help' => 'Vuelve a introducir la contraseña asegurandote de que coincidan',
                'attr' => ['class' => 'form-control'],
                'mapped' => false
            ])

            ->add('data_naixament', BirthdayType::class, [
                'label' => 'Fecha de nacimiento',
                'help' => 'Este campo es opcional.',
                'attr' => ['class' => 'form-control'],
                'placeholder' => [
                    'day' => 'Dia',
                    'month' => 'Mes',
                    'year' => 'Año',
                ],
                'format' => 'dd  MM  yyyy',
                'required' => false,
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "Debes aceptar los términos y condiciones",
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
