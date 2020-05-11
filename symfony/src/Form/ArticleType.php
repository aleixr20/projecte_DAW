<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Lenght;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titol', TextType::class, [
                'label' => 'Titol article',  
                'attr' => ['class' => 'form-control'],
                // 'constraints' => [
                //     new Length([
                //         'min' => 25,
                //         'minMassage' => 'Error, menys de {{ limit }} ',
                //         'max' => 100,
                //         'maxMassage' => 'Error, més de {{ limit }} ',
                //      ]) 
                //     ]
                ])

            ->add('subtitol', TextType::class, [
                'label' => 'Subtitol article',  
                'attr' => ['class' => 'form-control'],
                // 'constraints' => [
                //     new Length([
                //         'min' => 50,
                //         'minMassage' => 'Error, menys de {{ limit }} ',
                //         'max' => 150,
                //         'maxMassage' => 'Error, més de {{ limit }} ',
                //      ]) 
                //     ]
                ])

            ->add('contingut', TextareaType::class, [
                'label' => 'Contingut article',  
                'attr' => ['class' => 'form-control', 'rows' => 5]
                ])

            ->add('tag_meta', TextType::class, [
                'label' => 'etiquetes posicionament SEO',  
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
            ])

            ->add('tag_web', TextType::class, [
                'label' => 'etiquetes buscador intern',  
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
            ])

            ->add('tema', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
