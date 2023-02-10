<?php

namespace App\Controller;

use App\Repository\HoraireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(HoraireRepository $horaireRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'horaire' => $horaireRepository->findBy([], ['startDate' => 'asc']),
        ]);
    }

    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }


}
