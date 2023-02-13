<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Horaire;
use App\Form\HoraireType;
use App\Form\SearchForm;
use App\Repository\HoraireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HoraireController extends AbstractController
{

    #[Route('/', name: 'app_horaire')]
    public function index(Request $request, EntityManagerInterface $entityManager, HoraireRepository $horaireRepository): Response
    {
        // form recherche
        $data = new SearchData();
        $form_data =  $this->createForm(SearchForm::class, $data);
        $form_data->handleRequest($request);
        $horaires = $horaireRepository->findSearch($data);


        // formulaire pour ajouter un nouvel horaire
        $horaire = new Horaire();

        $form = $this->createForm(HoraireType::class, $horaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            date_default_timezone_set('Europe/Paris');
            // je récupère la date et l'heure de début et de fin
            $horaire->setCreatedDate(new \DateTime());
            $horaire->setModifiedDate(new \DateTime());

            // --------- calcul de la durée de chaque horaire ------------
            // je fais la différence entre ma date de début (startDate) et ma date de fin (endDate)
            $interval = $horaire->getStartDate()->diff($horaire->getEndDate());
            $formated_interval = $interval->format('%y année(s) / %m mois / %djour(s)  %H:%I:%S');
            // je met la durée dans "totalDate"
            $horaire->setTotalDate($formated_interval);


            $entityManager->persist($horaire);
            $entityManager->flush();

            // ... effectuer une action, telle que l'enregistrement de la tâche dans la base de données.
            $this->addFlash('success', 'L\'ajout a bien été pris en compte');

            return $this->redirectToRoute('app_horaire');
        }

        return $this->render('admin/horaire/index.html.twig', [
            'form_add_horraire' => $form->createView(),
            'form_search' => $form_data->createView(),
            'horaires' => $horaires,

        ]);
    }


    #[Route('/edit_horaire/{name}', name: 'app_edit_horaire', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit_marque(Horaire $horaire, HoraireRepository $horaireRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        // form recherche
        $data = new SearchData();
        $form_data =  $this->createForm(SearchForm::class, $data);
        $form_data->handleRequest($request);

        $form = $this->createForm(HoraireType::class, $horaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            date_default_timezone_set('Europe/Paris');
            //     $date = date('m/d/Y h:i:s a', time());
            //    strftime(" in French %A  %H : %M : %S and");
            $horaire->setModifiedDate(new \DateTime());

            // --------- calcul de la durée de chaque horaire ------------
            // je fais la différence entre ma date de début (startDate) et ma date de fin (endDate)
            $interval = $horaire->getStartDate()->diff($horaire->getEndDate());
            $formated_interval = $interval->format('%y année(s) / %m mois / %d jour(s)  %H:%I:%S');
            // je met la durée dans "totalDate"
            $horaire->setTotalDate($formated_interval);


            $entityManager->persist($horaire); // On confie notre entité à l'entity manager (on persist l'entité)
            $entityManager->flush(); // On execute la requete

            // ... effectuer une action, telle que l'enregistrement de la tâche dans la base de données.
            $this->addFlash('success', 'Votre modification a bien été prise en compte');

            return $this->redirectToRoute('app_horaire');
        }

        return $this->render('admin/horaire/edit.html.twig', [
            'horaire' => $horaireRepository->findBy([], ['name' => 'asc']),
            'form_edit_horraire' => $form->createView(),
            'form_search' => $form_data->createView(),
        ]);
    }

    #[Route('/delete_horaire/delete/{id}', name: 'app_delete_horaire')]
    public function delete_horaire(Request $request, EntityManagerInterface $entityManager): Response
    {

        $horaires = $entityManager->getRepository(Horaire::class)->find($request->get('id'));

        $entityManager->remove($horaires);

        $entityManager->flush();

        $this->addFlash('success', 'La suppression a bien été prise en compte');

        return $this->redirectToRoute('app_horaire');
    }
}
