<?php

namespace App\Form;

use App\Entity\Musique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MusiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isGlobal')
            ->add('musique', FileType::class, [
                'label' => 'Musique (mp3 file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '20480k',
                        'mimeTypes' => [
                            'audio/mpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid mp3 document',
                    ])
                ],
            ])->add('groupe', TextType::class, [
            'label' => 'Nom du groupe',
            'required' => false,
            'mapped' => false,
        ])->add('titre', TextType::class, [
                'label' => 'Nom de la musique',
                'required' => true,
                'mapped' => false,
            ])->add('album', TextType::class, [
                'label' => 'Nom de l\'album',
                'required' => false,
                'mapped' => false,
            ])->add('artiste', TextType::class, [
                'label' => 'Nom de l\'artiste',
                'required' => false,
                'mapped' => false,
                ])->add('date', DateType::class, [
                'label' => 'Date de sortie',
                'required' => false,
                'mapped' => false,
            ])->add('themes', TextType::class, [
                'label' => 'Thèmes',
                'required' => false,
                'mapped' => false,
            ])->add('tags', TextType::class, [
                'label' => 'Tags',
                'required' => false,
                'mapped' => false,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Musique::class,
        ]);
    }
}
