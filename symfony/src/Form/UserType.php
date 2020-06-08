<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
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
                        'minMessage' => 'El nombre no puede ser inferior a {{ limit }} caracteres',
                        'max' => 40,
                        'maxMessage' => 'El nombre no puede ser superior a {{ limit }} caracteres',
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
                'help' => 'Dirección de correo electrónico.',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'El mail no puede ser superior a {{ limit }} caracteres',
                    ])
                ]
            ])

            ->add('nom_usuari', TextType::class, [
                'label' => 'Nombre de usuario',
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

            ->add('imatge', FileType::class, [
                'label' => 'Seleccionar una imagen (jpg, png)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2000k',
                    ])
                ],
                'label_attr' => ['class' => 'custom-file-label']
            ])

            ->add('descripcio', TextAreaType::class, [
                'label' => 'Presentación',
                'help' => 'Una pequeña descripción, es el texto que se verà en el listado de artículos. Este campo es opcional y no puede contener más de 2000 caracteres',
                'attr' => ['class' => 'form-control', 'rows' => '6'],
                'constraints' => [
                    new Length([
                        'max' => 2000,
                        'maxMessage' => 'La presentación no puede ser superior a {{ limit }} caracteres',
                    ]),
                ],
                'required' => false,
            ])


            ->add('github', TextType::class, [
                'label' => 'Github',
                'help' => 'Nombre de usuario de Github. Sólo el nombre de usuario. No es necesario escribir la url http/:/www.github...',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('linkedin', TextType::class, [
                'label' => 'Linkedin',
                'help' => 'Nombre de usuario de Linkedin. Sólo el nombre de usuario. No es necesario escribir la url http/:/www.linkedin...',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('twitter', TextType::class, [
                'label' => 'Twitter',
                'help' => 'Nombre de usuario de Twitter. Sólo el nombre de usuario. No es necesario escribir la url http/:/www.twitter...',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('facebook', TextType::class, [
                'label' => 'Facebook',
                'help' => 'Nombre de usuario de Facebook. Sólo el nombre de usuario. No es necesario escribir la url http/:/www.facebook...',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])

            ->add('data_naixament', BirthdayType::class, [
                'label' => 'Fecha de nacimiento',
                'help' => 'Este campo es opcional. ',
                // 'attr' => ['class' => 'form-control'],
                'placeholder' => [
                    'day' => 'Día',
                    'month' => 'Mes',
                    'year' => 'Año',
                ],
                'format' => 'dd  MM  yyyy',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
