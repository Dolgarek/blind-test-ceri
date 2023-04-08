<?php

namespace App\Form;

use App\Entity\Musique;
use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class MusiqueType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isGlobal')
            ->add('musique', FileType::class, [
                'label' => 'Musique (mp3 file)',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '204800k',
                        'mimeTypes' => [
                            'audio/mpeg',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un fichier mp3 valide',
                    ])
                ],
                'attr' => [
                    'class' => 'formSelectDate',
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
            ])->add('groupe', TextType::class, [
            'label' => 'Nom du groupe',
            'required' => false,
            'mapped' => false,
            'attr' => [
                'class' => 'form-control-sm',
            ],
            'label_attr' => [
                'class' => 'profileLabelText',
            ],
        ])->add('titre', TextType::class, [
                'label' => 'Nom de la musique',
                'required' => true,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control-sm',
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
            ])->add('album', TextType::class, [
                'label' => 'Nom de l\'album',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control-sm',
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
            ])->add('artiste', TextType::class, [
                'label' => 'Nom de l\'artiste',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control-sm',
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
                ])->add('date', DateType::class, [
                'label' => 'Date de sortie',
                'required' => false,
                'mapped' => false,
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
            ])->add('themes', EntityType::class, [
                'label' => 'Thèmes',
                'required' => false,
                'mapped' => false,
                'class' => Theme::class,
                'multiple' => true,
                'expanded' => false,
                'attr' => [
                    'class' => 'formSelectDate',
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ]
            ])->add('tags', TextType::class, [
                'label' => 'Tags',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control-sm',
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
            ])->add('timestamp', IntegerType::class, [
                'label' => 'Timestamp',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control-sm',
                ],
                'label_attr' => [
                    'class' => 'profileLabelText',
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Musique::class,
        ]);
    }
}
