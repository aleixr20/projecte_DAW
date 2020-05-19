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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('titol', TextType::class, [
                'label' => 'Titol article',
                'help' => 'Títol molt curt i descriptiu del article (10-50 caràcters)',
                // 'attr' => ['class' => 'form-control', 'minlength' => '4', 'maxlength' => '10'],
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Error, el titol no pot contenir menys de {{ limit }} caràcters',
                        'max' => 50,
                        'maxMessage' => 'Error, el títol no pot contenir mes de {{ limit }} caràcters ',
                    ])
                ]
            ])

            ->add('subtitol', TextType::class, [
                'label' => 'Breu resum del contingut del article',
                'help' => 'Una petita descripció, Es el text que es veurà en el llistat d\'articles. Aquest camp es opcional',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 50,
                        'minMessage' => 'Error, el resum no pot contenir menys de {{ limit }} caràcters',
                        'max' => 200,
                        'maxMessage' => 'Error, el resum no pot contenir mes de {{ limit }} caràcters',
                    ])
                ],
                'required' => false,

            ])

            ->add('meta_tag', TextType::class, [
                'label' => 'Meta Tags',
                'help' => 'Paraules clau del article separades per comes. Seràn les meta-tag per al posicionament SEO',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('meta_description', TextType::class, [
                'label' => 'Meta Description',
                'attr' => ['class' => 'form-control', 'rows' => 2],
                'help' => 'Text molt resumit i descriptiu per al Snippet dels buscadors. (maxim 155 caràcters)',

                'constraints' => [
                    new Length([
                        'min' => 100,
                        'minMessage' => 'Error, la meta descripció no pot contenir menys de {{ limit }} caràcters',
                        'max' => 160,
                        'maxMessage' => 'Error, la meta descricpió no pot contenir mes de {{ limit }} caràcters',
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
            ->add('contingut', CKEditorType::class, [
                'label' => 'Contingut article',
                'attr' => ['class' => 'form-control', 'rows' => 5]

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
