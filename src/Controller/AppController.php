<?php

namespace App\Controller;

use App\Repository\Repository;
use App\Repository\PisteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }


    #[Route('/piste', name: 'app_piste')]
    public function piste(Request $request, PisteRepository $pisteRepository): Response
    {
        $pistes = $pisteRepository->findAll();

        return $this->render('app/piste.html.twig', [
            'controller_name' => 'AppController',
            'pistes' => $pistes,
        ]);
    }
}
