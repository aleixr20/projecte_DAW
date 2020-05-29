<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
                'label' => 'Titol article *',
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

            ->add('resum', TextareaType::class, [
                'label' => 'Breu resum del contingut del article',
                'help' => 'Una petita descripció, Es el text que es veurà en el llistat d\'articles. Aquest camp es opcional',
                'attr' => ['class' => 'form-control', 'rows' => 2],
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
                'label' => 'Meta Tags *',
                'help' => 'Paraules clau del article separades per comes. Seràn les meta-tag per al posicionament SEO',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('meta_description', TextareaType::class, [
                'label' => 'Meta Description *',
                'attr' => ['class' => 'form-control', 'rows' => 2],
                'help' => 'Text molt resumit i descriptiu per al Snippet dels buscadors. (de 100 a 155 caràcters)',

                'constraints' => [
                    new Length([
                        'min' => 100,
                        'minMessage' => 'Error, la meta descripció no pot contenir menys de {{ limit }} caràcters',
                        'max' => 160,
                        'maxMessage' => 'Error, la meta descricpió no pot contenir mes de {{ limit }} caràcters',
                    ])
                ]
            ])

            ->add('categoria1', EntityType::class, [
                'label' => 'Categoria principal *',
                'help' => 'Categoria a la que pertany l\'article. Tot i que pots assignar-ne 3, millor si en poses nomes 1.\n\rPer triar nomes 1 categoria, posa la mateixa als tres selectors',
                'attr' => ['class' => 'form-control'],
                'class' => Categoria::class,
                'mapped' => false,
            ])
            ->add('categoria2', EntityType::class, [
                'label' => 'Categoria secundaria',
                //'help' => 'Categoria a la que pertany l\'article',
                'attr' => ['class' => 'form-control'],
                'class' => Categoria::class,
                'mapped' => false,
                'required' => false,
            ])
            ->add('categoria3', EntityType::class, [
                'label' => 'Categoria alternativa',
                //'help' => 'Categoria a la que pertany l\'article',
                'attr' => ['class' => 'form-control'],
                'class' => Categoria::class,
                'mapped' => false,
                'required' => false,
            ])

            ->add('nova_categoria', TextType::class, [
                'label' => 'Nova categoria *',
                //'help' => 'Nom que tindrà la nova categoria. Recorda que totes les categories comencen amb in (inPHP, inHTML...)',
                'attr' => ['class' => 'form-control'],
                'mapped' => false,
                'required' => false,
            ])
            ->add('contingut', CKEditorType::class, [
                'label' => 'Contingut article *',
                //'help' => 'Compte amb les etiquetes html. Recorda que els fragments de codi s\'obren amb <pre> i s\'han de tancar amb </pre> sense tabulacions',
                'attr' => ['class' => 'form-control', 'rows' => 5]

            ])
            ->add('html', TextareaType::class, [
                'label' => 'Contingut html ide embed *',
                //'help' => 'Compte amb les etiquetes html. Recorda que els fragments de codi s\'obren amb <pre> i s\'han de tancar amb </pre> sense tabulacions',
                'attr' => ['class' => 'form-control', 'rows' => 5],
                'required' => false
            ])
            ->add('css', TextareaType::class, [
                'label' => 'Contingut css ide embed *',
                //'help' => 'Compte amb les etiquetes html. Recorda que els fragments de codi s\'obren amb <pre> i s\'han de tancar amb </pre> sense tabulacions',
                'attr' => ['class' => 'form-control', 'rows' => 5],
                'required' => false
            ])
            ->add('js', TextareaType::class, [
                'label' => 'Contingut js ide embed *',
                //'help' => 'Compte amb les etiquetes html. Recorda que els fragments de codi s\'obren amb <pre> i s\'han de tancar amb </pre> sense tabulacions',
                'attr' => ['class' => 'form-control', 'rows' => 5],
                'required' => false
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
