<?php

namespace App\Controller;

use App\Entity\Station;
use App\Repository\PisteRepository;
use App\Repository\RemonteeRepository;
use App\Repository\StationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $time = date("h:m:s");
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }


    #[Route('/automatic', name: 'app_auto')]
    public function auto(PisteRepository $pisteRepository, RemonteeRepository $remonteeRepository): Response
    {
        $time = date("h:m:s");
        $pistes = $pisteRepository->findAll();
        $remontees = $remonteeRepository->findAll();
        foreach ($pistes as $piste) {
            if ($time >= $piste->getHoraireOuverture()&& $piste->getOuverture() == false){
                $piste->setOuverture(true);
            }
            elseif ($time >= $piste->getHoraireFermeture() && $piste->getOuverture() == true){
                $piste->setOuverture(false);
            }
        }
        foreach ($remontees as $remontee) {
            if ($time >= $remontee->getOpenTime() && $remontee->getOpen() == false){
                $remontee->setOpen(true);
            }
            elseif ($time >= $remontee->getCloseTime() && $remontee->getOpen() == true){
                $remontee->setOpen(false);
            }
        }

        return $this->json("ok");
    }
    #[Route('/edit', name: 'app_edit')]
    public function edit(StationRepository $stationRepository): Response
    {
        $station = $stationRepository->findAll();
        return $this->render('app/edit.html.twig', [
            'station' => $station,
        ]);
    }
    #[Route('/edit/station/{id}', name: 'station_edit')]
    public function Sedit(StationRepository $stationRepository, $id): Response
    {
        $station = $stationRepository->findOneBy($id);
        return $this->render('app/S edit.html.twig', [
            'station' => $station,
        ]);
    }

}
