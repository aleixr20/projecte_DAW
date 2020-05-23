<?php

namespace App\Form;

use App\Entity\Categoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class AdminCategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom', TextType::class, [
                'label' => 'Nom de la categoria',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('tipus', ChoiceType::class, [
                'label' => 'Tipus de categoria',

                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'frontend' => 'Frontend',
                    'backend' => 'Backend',
                    'sitemes' => 'sistemes',
                    'altres' => 'altres',
                    'oculta' => 'oculta',

                ],
            ])

            ->add('logo', FileType::class, [
                'label' => 'Arxiu amb la imatge (png, jpg o gif) de la icona/logo de la categoria',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/gif',
                            'image/svg+xml'
                        ],
                        'mimeTypesMessage' => 'Puja una imatge vàlida (PNG, JPEG o GIF)',
                    ])
                ],
            ])


            ->add('color', TextType::class, [
                'label' => 'Color representatiu del logo',
                'attr' => ['class' => 'form-control'],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categoria::class,
        ]);
    }
}
