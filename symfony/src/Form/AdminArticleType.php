<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AdminArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('data_publicacio', DateType::class, [
                'label' => 'Data de publicació',       
                'placeholder' => [
                    'day' => 'Dia',
                    'month' => 'Mes',
                    'year' => 'Any',
                ],
                'format' => 'dd  MM  yyyy',
            ])

            ->add('data_actualitzacio', DateType::class, [
                'label' => 'Ultima actualització',
                // 'attr' => ['class' => 'form-control'],
                'placeholder' => [
                    'day' => 'Dia',
                    'month' => 'Mes',
                    'year' => 'Any',
                ],
                'format' => 'dd  MM  yyyy',
                'required' => false
            ])

            ->add('autor', EntityType::class, [
                'label' => 'Autor de l\'article',
                //'help' => 'Categoria a la que pertany l\'article',
                'attr' => ['class' => 'form-control'],
                'class' => User::class,
            ])

            ->add('visible', ChoiceType::class, [
                'label' => 'Estat de l\'article',
                'attr' => ['class' => 'form-control'],
                //'help' => 'Indica el grau de visibilitat de l\'article',
                'choices'  => [
                    'Esborrany' => false,
                    'Publica' => true,
                ],
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
