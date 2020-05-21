<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom', TextType::class, [
                'label' => 'Nom *',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'El nom no pot ser inferior a {{ limit }} caràcters',
                        'max' => 40,
                        'maxMessage' => 'El nom no pot ser superior a {{ limit }} caràcters',
                    ])
                ]
            ])

            ->add('cognom', TextType::class, [
                'label' => 'Cognom *',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'El cognom no pot ser inferior a {{ limit }} caràcters',
                        'max' => 40,
                        'maxMessage' => 'El cognom no pot ser superior a {{ limit }} caràcters',
                    ])
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'help' => 'Adreça de correu electrònic on rebre la verificació del registre.',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'El mail no pot ser superior a {{ limit }} caràcters',
                    ])
                ]
            ])

            ->add('nom_usuari', TextType::class, [
                'label' => 'Nom d\'usuari',
                'help' => 'Aques serà el teu nom públic. Ha de ser unic i de 8 a 14 caràcters.',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'El nom d\'usuari no pot ser inferior a {{ limit }} caràcters',
                        'max' => 14,
                        'maxMessage' => 'El nom d\'usuari no pot ser superior a {{ limit }} caràcters',
                    ])
                ]
            ])

            ->add('imatge', FileType::class, [
                'label' => 'Seleccionar una imatge (jpg, png)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2000k',
                    ])
                ],
                'label_attr' => ['class' => 'custom-file-label']
            ])

            ->add('descripcio', TextAreaType::class, [
                'label' => 'Presentació',
                'help' => 'Una petita descripció, Es el text que es veurà en el llistat d\'articles. Aquest camp es opcional',
                'attr' => ['class' => 'form-control', 'rows' => '6'],
                'constraints' => [
                    new Length([
                        'max' => 2000,
                        'maxMessage' => 'La descripció no pot ser superior a {{ limit }} caràcters',
                    ]),
                ],
                'required' => false,
            ])


            ->add('github', TextType::class, [
                'label' => 'Github',
                'help' => 'Nom d\'usuari de Github. Nomes el nom d\'usuari. No cal escriure la url http/:/www.github...',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('linkedin', TextType::class, [
                'label' => 'Linkedin',
                'help' => 'Nom d\'usuari de Linkedin. Nomes el nom d\'usuari. No cal escriure la url http/:/www.linkedin...',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('twitter', TextType::class, [
                'label' => 'Twitter',
                'help' => 'Nom d\'usuari de Twitter. Nomes el nom d\'usuari. No cal escriure la url http/:/www.twitter...',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('facebook', TextType::class, [
                'label' => 'Facebook',
                'help' => 'Nom d\'usuari de Facebook. Nomes el nom d\'usuari. No cal escriure la url http/:/www.facebook...',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])

            ->add('data_naixament', BirthdayType::class, [
                'label' => 'Data de naixement',
                'help' => 'Aquest camp es opcional. ',
                'attr' => ['class' => 'form-control'],
                'placeholder' => [
                    'day' => 'Dia',
                    'month' => 'Mes',
                    'year' => 'Any',
                ],
                'format' => 'dd  MM  yyyy',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
