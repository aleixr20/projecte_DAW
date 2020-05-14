<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Validator\Constraints\Length;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('titol', TextType::class, [
                'label' => 'Titol article',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 25,
                        'minMessage' => 'Error, menys de {{ limit }} ',
                        'max' => 100,
                        'maxMessage' => 'Error, més de {{ limit }} ',
                    ])
                ]
            ])

            ->add('subtitol', TextType::class, [
                'label' => 'Subtitol article',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 50,
                        'minMessage' => 'Error, menys de {{ limit }} ',
                        'max' => 150,
                        'maxMessage' => 'Error, més de {{ limit }} ',
                    ])
                ]
            ])

            ->add('contingut', CKEditorType::class, [
                'label' => 'Contingut article',
                'attr' => ['class' => 'form-control', 'rows' => 5]

            ])

            ->add('meta_tag', TextType::class, [
                'label' => 'etiquetes posicionament SEO',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('meta_description', TextAreaType::class, [
                'label' => 'Breu descripcio Snippet SEO (maxim 155 caràcters)',
                'attr' => ['class' => 'form-control', 'rows' => 2],
                'constraints' => [
                    new Length([
                        'min' => 100,
                        'minMessage' => 'Error, menys de {{ limit }} ',
                        'max' => 160,
                        'maxMessage' => 'Error, més de {{ limit }} ',
                    ])
                ]
            ])

            ->add('categoria', EntityType::class, [
                'attr' => ['class' => 'form-control'],
                'class' => Categoria::class,
            ])

            ->add('nova_categoria', TextType::class, [
                'label' => 'Nova categoria',
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
                'required' => false,
            ])

            ->add('visible', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
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
