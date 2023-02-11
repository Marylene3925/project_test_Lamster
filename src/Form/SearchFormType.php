<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\TypeHoraire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{

    // construction de notre formulaire
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ajout d'un champ pour taper notre recherche(q), je précise qu'on est dans le cadre d'un textType,
            ->add('q', TextType::class, [
                'label' => false,

                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'

                ]
            ])

            ->add('typeHoraire', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => TypeHoraire::class,
                // checkbox
                'expanded' => true,
                'multiple' => true,
                'attr' => [
                    'placeholder' => 'Rechercher',
                    'class' => 'mt-3 mb-4',

                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // qu'elle class sert à représenté nos données
            'data_class' => SearchData::class,
            // je précise que le form tuilise une methode get par défaut
            'method' => 'GET',
            // je desactive la protecion CSRF, puisqu'on est dans un form de recherche
            'csrf_protection' => false
        ]);
    }

    // getBlockPrefix permet d'eviter de tous mettre dans un tableau qui s'appel SearchData et enlève les préfixes, pour avoir une url la plus propre possible, je vais retourner une simple chaine de caractère
    public function getBlockPrefix()
    {
        return '';
    }
}
