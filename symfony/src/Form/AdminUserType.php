<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom_usuari', TextType::class, [
                'label' => 'Nom d\'usuari *',
                'attr' => ['class' => 'form-control']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'attr' => ['class' => 'form-control']
            ])


            ->add('roles', ChoiceType::class, [
                'label' => 'Roles *',
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'USER' => 'ROLE_USER',
                    'VALIDATED' => 'ROLE_VALIDATED',
                    'ADMIN' => 'ROLE_ADMIN'
                ],
                'mapped' => false,
            ])

            ->add('data_registre', DateType::class, [
                'label' => 'Data de registre',
                'placeholder' => [
                    'day' => 'Dia',
                    'month' => 'Mes',
                    'year' => 'Any',
                ],
                'format' => 'dd  MM  yyyy',
            ])

            ->add('imatge', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Eliminar imatge de perfil',
                'choices' => [
                    'Mantenir' => false,
                    'Eliminar' => true,
                ],
                'mapped' => false,
            ])

            ->add('descripcio', TextareaType::class, [
                'label' => 'Text del perfil',
                'attr' => ['class' => 'form-control', 'rows' => 7],
                'required' => false
            ])
            ->add('github', TextType::class, [
                'label' => 'Github',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('linkedin', TextType::class, [
                'label' => 'Linkedin',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('twitter', TextType::class, [
                'label' => 'Twitter',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('facebook', TextType::class, [
                'label' => 'Facebook',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
