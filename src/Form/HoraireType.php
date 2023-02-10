<?php

namespace App\Form;

use App\Entity\Horaire;
use App\Entity\TypeHoraire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class HoraireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nom de l\'horaire'
                ],
                'label' => 'Nom de l\'horaire (ex: Jour, Nuit, Weekend...)'
            ])

            ->add('comment', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez un commentaire (optionnel)'
                ],
                'label' => 'Commentaire (optionnel)'
            ])

            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
            ])



            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
            ])


            ->add('typeHoraire', EntityType::class, [
                // looks for choices from this entity
                'class' => TypeHoraire::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'name',
                'label' => 'choisir un type d\'horaire',
                'required' => true,
            ])

            ->add('priority', ChoiceType::class, [
                'choices'  => [
                    "priorité 1" => "1",
                    "priorité 2" => "2",
                    "priorité 3" => "3",
                ],

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Horaire::class,
        ]);
    }
}
