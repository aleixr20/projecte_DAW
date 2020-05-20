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
                'label' => 'Nom d\'usuari',
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

            ->add('imatge', FileType::class, [
                'label' => 'Seleccionar una imatge (jpg, png)',
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
                'label' => 'Presentació',
                'attr' => ['class' => 'form-control', 'rows' => '6'],
                'required' => false,
            ])

            
            ->add('github', TextType::class, [
                'label' => 'Github',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('linkedin', TextType::class, [
                'label' => 'Linkedin',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('twitter', TextType::class, [
                'label' => 'Twitter',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('facebook', TextType::class, [
                'label' => 'Facebook',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])

            ->add('data_naixament', BirthdayType::class, [
                'label' => 'Data de naixament',
                'placeholder' => [
                    'day' => 'Dia',
                    'month' => 'Mes',
                    'year' => 'Any',
                ],
                'format' => 'dd  MM  yyyy',
                'attr' => ['class' => 'form-control'],
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
