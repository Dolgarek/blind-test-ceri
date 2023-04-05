<?php

namespace App\Controller;

use App\Entity\Theme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                'class' => 'form-select',
            ],
            'label_attr' => [
                'class' => 'form-label mt-2',
            ],
        ])->add('tags', TextType::class, [
            'label' => 'Tags',
            'label_attr' => [
                'class' => 'form-label mt-2',
            ],
            'required' => false,
            'mapped' => true,
            'attr' => [
                'class' => 'form-control-custom',
            ],
            'help' => 'Séparez les tags par une virgule',
            'help_attr' => [
                'class' => 'form-text',
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
            'attr' => [
                'class' => 'form-select',
            ],
            'label' => 'Difficulté',
            'label_attr' => [
                'class' => 'form-label mt-2',
            ],
            'required' => true,
            'mapped' => true,
        ]);
    }

    /*public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => null,
        ]);
    }*/
}