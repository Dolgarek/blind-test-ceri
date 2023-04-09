<?php

namespace App\Form;

use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class ConfigPartieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('themes', EntityType::class, [
            'label' => 'Thèmes',
            'required' => true,
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
            'mapped' => true,
            'help' => 'Séparez les tags par une virgule',
            'help_attr' => [
                'class' => 'form-text',
            ],
            'attr' => [
                'class' => 'form-control-sm',
            ],
            'label_attr' => [
                'class' => 'profileLabelText',
            ],
        ])->add('difficulte', ChoiceType::class, [
            'choices'  => [
                'Facile' => 1,
                'Moyen' => 2,
                'Difficile' => 3,
            ],
            'choice_attr' => [
                'Moyen' => ['selected' => true]
            ],
            'label' => 'Difficulté',
            'required' => true,
            'mapped' => true,
            'label_attr' => [
                'class' => 'profileLabelText',
            ],
            'attr' => [
                'class' => 'formSelectChoice',
            ],
        ])->add('nbMusic', IntegerType::class, [
            'label' => 'Nombre de musique',
            'label_attr' => [
                'class' => 'profileLabelText',
            ],
            'required' => true,
            'mapped' => true,
            'attr' => [
                'class' => 'form-control-sm',
            ],
            'help' => 'Minimum 1 et maximum 100',
            'help_attr' => [
                'class' => 'form-text',
            ],
            'constraints' => [
                new LessThanOrEqual([
                    'value' => 100,
                    'message' => 'Le nombre de musique doit être inférieur à 100',
                ]),
                new GreaterThanOrEqual([
                    'value' => 1,
                    'message' => 'Le nombre de musique doit être supérieur à 1',
                ]),
            ],
        ]);
    }

    /*public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => null,
        ]);
    }*/
}