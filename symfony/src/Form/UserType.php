<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email *'
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom *'
            ])
            ->add('cognom', TextType::class, [
                'label' => 'Cognom *'
            ])
            ->add('data_naixament', BirthdayType::class, [
                'label' => 'Data de naixament',
                'required'=> false,
                'placeholder' => [
                    'day' => 'Dia',
                    'month' => 'Mes', 
                    'year' => 'Any', 
                ],
                'format' => 'dd  MM  yyyy'
            ])
            ->add('genere', ChoiceType::class, [
                'label' => 'Génere',
                'required'=> false,
                'choices' => [
                    'Masculí' => 'masc',
                    'Femení' => 'fem',
                    'Altres' => 'altres'
                ]
            ])
            ->add('codi_postal', TextType::class, [
                'required'=> false,
            ])
            ->add('nom_usuari', TextType::class)
            ->add('imatge', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2000k',
                    ])
                ],
            ])
            ->add('github', TextType::class, [
                'required'=> false,
            ])
            ->add('codi_postal', TextType::class, [
                'required'=> false,
            ])
            ->add('linkedin', TextType::class, [
                'required'=> false,
            ])
            ->add('twitter', TextType::class, [
                'required'=> false,
            ])
            ->add('facebook', TextType::class, [
                'required'=> false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
