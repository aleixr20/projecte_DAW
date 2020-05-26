<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titol')
            ->add('resum')
            ->add('slug')
            ->add('meta_tag')
            ->add('meta_description')
            ->add('contingut')
            ->add('html')
            ->add('css')
            ->add('js')
            ->add('data_publicacio')
            ->add('data_actualitzacio')
            ->add('visible')
            ->add('categories')
            ->add('autor')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
