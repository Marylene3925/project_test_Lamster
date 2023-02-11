<?php

namespace App\Controller;

use App\Repository\HoraireRepository;
use App\Repository\TypeHoraireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchController extends AbstractController
{
    // -------------- Page horaire----------------------

    // formulaire de nottre barre de recherche pour la page horaire
    #[Route('/UserSearchBarHoraire', name: 'UserSearchBarHoraire')]
    public function UserSearchBarHoraire()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearHoraire'))
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control ',
                    'placeholder' => 'Rechercher un horaire...'
                ]
            ])
            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-success pl-4 '
                ]
            ])
            ->getForm();
        return $this->render('search/searchBarUser.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // la page sui s'affiche lorsque l'on à appuyer sur le bouton entrer de la barre de recherche pour les horaires
    #[Route('/handleSearHoraire', name: 'handleSearHoraire')]
    public function handleSearHoraire(Request $request, HoraireRepository $horaireRepository): Response
    {

        $query = $request->request->all('form')['query'];
        if ($query) {
            $horaires = $horaireRepository->findByNom($query);
        }
        

        return $this->render('search/horaire.html.twig', [
            'horaires' => $horaires,
        ]);
    }

    // --------------------------- page type ---------------------------------

    #[Route('/UserSearchBarTypeHoraire', name: 'UserSearchBarTypeHoraire')]
    public function UserSearchBarTypeHoraire()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearchTypeHoraire'))
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control ',
                    'placeholder' => 'Rechercher ...'
                ]
            ])
            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-success pl-4 '
                ]
            ])
            ->getForm();
        return $this->render('search/searchBarUser.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // la page sui s'affiche lorsque l'on à appuyer sur le bouton entrer de la barre de recherche pour les types horaires
    #[Route('/handleSearchTypeHoraire', name: 'handleSearchTypeHoraire')]
    public function handleSearhTypeHoraire(Request $request,TypeHoraireRepository $typeHoraireRepository): Response
    {

        $query = $request->request->all('form')['query'];
        if ($query) {
            $typeHoraires = $typeHoraireRepository->findByNomTypeHoraire($query);
        }
        

        return $this->render('search/type_horaire.html.twig', [
            'typeHoraires' => $typeHoraires
        ]);
    }
}
