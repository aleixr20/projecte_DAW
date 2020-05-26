<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('cognom')
            ->add('nom_usuari')
            ->add('email')
            ->add('token')
            ->add('password')
            ->add('roles')
            ->add('data_registre')
            ->add('ultim_login')
            ->add('data_naixament')
            ->add('imatge')
            ->add('github')
            ->add('linkedin')
            ->add('twitter')
            ->add('facebook')
            ->add('descripcio')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
