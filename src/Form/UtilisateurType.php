<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Entity\Partie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;


class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom de l \'utilisateur',
                'required' => true,
                'attr' => [
                    'class' => 'form-control-sm',
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
            ])
            ->add('password',TextType::class, [
                'label' => 'Mot de passe',
                'required' => true,
                'attr' => [
                    'class' => 'form-control-sm',
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
            ])
            ->add('nom',TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'class' => 'form-control-sm',
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
            ])
            ->add('prenom',TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'class' => 'form-control-sm',
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
            ])
            ->add('createdAt', DateType::class, [
                'label' => 'Date de sortie',
                'required' => true,
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y') - 100),
                'constraints' => [
                    new LessThanOrEqual('today')
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
                'attr' => [
                    'class' => 'formSelectDate',
                ],
            ])->add('accordUtilisateur', ChoiceType::class, [
                'label' => 'Accord de l\'utilisateur',
                'required' => false,
                'choices'  => [
                    'Null' => null,
                    'Oui' => true,
                    'Non' => false,
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
                'attr' => [
                    'class' => 'formSelectChoice',
                ],
            ])->add('connexion', ChoiceType::class, [
                'label' => 'Connection',
                'required' => false,
                'choices'  => [
                    'Null' => null,
                    'Oui' => true,
                    'Non' => false,
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
                'attr' => [
                    'class' => 'formSelectChoice',
                ],
            ])->add('avatar', FileType::class, [
                'label' => 'Avatar(.jpg .png .jpeg)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10240k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Vuillez uploader une image valide',
                    ])
                    ],'attr' => [
                        'class' => 'formSelectDate',
                    ],
                    'label_attr' => [
                        'class' => 'profileLabelText',
                    ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
