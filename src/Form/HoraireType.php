<?php

namespace App\Form;

use App\Entity\Horaire;
use App\Entity\TypeHoraire;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                    'placeholder' => 'Entrez le nom de l\'horraire type'
                ],
                'label' => 'Nom de l\'horraire type (ex: Jour, Nuit, Weekend...)'
            ])

            ->add('comment', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez un commentaire (optionnel)'
                ],
                'label' => 'Commentaire (optionnel)'
            ])

            ->add('startDate', DateTime::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez une date et heure de début'
                ],
                'label' => 'Date et heure de début'
            ])

            ->add('endDate', DateTime::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez une date et heure de fin'
                ],
                'label' => 'Date et heure de fin'
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
                    "😀" => "1",                    
                    "🙂" => "2",                    
                    "☹️" => "3",
                    "😠" => "4",
                ],
                
            ])
            
         
            
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Horaire::class,
        ]);
    }
}
