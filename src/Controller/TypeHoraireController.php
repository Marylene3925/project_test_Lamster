<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeHoraireController extends AbstractController
{
    #[Route('/type/horaire', name: 'app_type_horaire')]
    public function index(): Response
    {
        return $this->render('type_horaire/index.html.twig', [
            'controller_name' => 'TypeHoraireController',
        ]);
    }
}
