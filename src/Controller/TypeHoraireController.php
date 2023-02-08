<?php

namespace App\Controller;

use App\Entity\TypeHoraire;
use App\Form\TypeHoraireType;
use App\Repository\TypeHoraireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeHoraireController extends AbstractController
{
    #[Route('/type_horaire', name: 'app_type_horaire')]
    public function index(Request $request, EntityManagerInterface $entityManager, TypeHoraireRepository $typeHoraireRepository): Response
    {

        // formulaire pour ajouter un nouveau type horaire
        $typeHoraire = new TypeHoraire();
        $form = $this->createForm(TypeHoraireType::class, $typeHoraire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->persist($typeHoraire);
            $entityManager->flush();

            // ... effectuer une action, telle que l'enregistrement de la tâche dans la base de données.
            $this->addFlash('success', 'L\'ajout a bien été pris en compte');

            return $this->redirectToRoute('app_type_horaire');
        }


        return $this->render('type_horaire/index.html.twig', [
            'form_add_typeHorraire' => $form->createView(),
            'type_horaire' => $typeHoraireRepository->findBy([], ['name' => 'asc']),
        ]);
    }

    
    #[Route('/edit_type_horaire/{name}', name: 'app_edit_type_horaire', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit_marque(TypeHoraire $typeHoraire,TypeHoraireRepository $typeHoraireRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeHoraireType::class, $typeHoraire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->persist($typeHoraire); // On confie notre entité à l'entity manager (on persist l'entité)
            $entityManager->flush(); // On execute la requete

            // ... effectuer une action, telle que l'enregistrement de la tâche dans la base de données.
            $this->addFlash('success', 'Votre modification a bien été prise en compte');

            return $this->redirectToRoute('app_type_horaire');
        }

        return $this->render('type_horaire/edit.html.twig', [
            'type_horaire' => $typeHoraireRepository->findBy([], ['name' => 'asc']),
            'form_edit_typeHorraire' => $form->createView()

        ]);
    }

    #[Route('/delete_typeHoraire/delete/{id}', name: 'app_delete_typeHoraire')]
    public function delete_typeHoraire(Request $request, EntityManagerInterface $entityManager): Response
    {
     
        $typeHoraires = $entityManager->getRepository(TypeHoraire::class)->find($request->get('id'));

        $entityManager->remove($typeHoraires);

        $entityManager->flush();

        $this->addFlash('success', 'La suppression a bien été prise en compte');

        return $this->redirectToRoute('app_type_horaire');
    }

}
