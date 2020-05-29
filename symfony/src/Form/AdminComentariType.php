<?php

namespace App\Form;

use App\Entity\Comentari;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Validator\Constraints\Length;



class AdminComentariType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipus', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Tipus de comentari',
                'choices' => [
                    '<i class="fa fa-frown-o"><i>' => 0,
                    '<i class="fa fa-frown-o"><i>' => 1,
                    '<i class="fa fa-frown-o"><i>' => 2,
                    '<i class="fa fa-frown-o"><i>' => 3,
                ],
            ])

            ->add('text', TextType::class, [
                'label' => 'Text del comentari *',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'max' => 500,
                        'maxMessage' => 'Error, el títol no pot contenir mes de {{ limit }} caràcters ',
                    ])
                ]
            ])

            ->add('visible', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Visibilitat del comentari',
                'choices' => [
                    'Pendent' => false,
                    'Public' => true,
                ],
            ])
            
            ->add('dataPublicacio', DateType::class, [
                'label' => 'Data del comentari',
                'placeholder' => [
                    'day' => 'Dia',
                    'month' => 'Mes',
                    'year' => 'Any',
                ],
                'format' => 'dd  MM  yyyy',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comentari::class,
        ]);
    }
}
