<?php

namespace App\Form;

use App\Entity\Comentari;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class ComentariType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Escriu aqui al teu comentari. Procura que no sigui superior a 500 caràcters'],
                'constraints' => [
                    new Length([
                        'max' => 500,
                        'maxMessage' => 'Error, el títol no pot contenir mes de {{ limit }} caràcters ',
                    ])
                ]
            ])
            ->add('tipus', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comentari::class,
        ]);
    }
}
