<?php

namespace App\Controller;

use App\Repository\GdomaineRepository;
use App\Repository\PisteRepository;
use App\Repository\RemonteeRepository;
use App\Repository\StationSkiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/domaine', name: 'app_Domaine')]
    public function index(GdomaineRepository $gdomaineRepository): Response
    {
        $domaine = $gdomaineRepository->findAll();

            return $this->render('front/domaine.html.twig', [
                'domaine' => $domaine,

            ]);
        }

    #[Route('/stations/{id}', name: 'app_Station')]
    public function stations(StationSkiRepository $stationSkiRepository, $id): Response
    {
        $station = $stationSkiRepository->findBy(['domain' => $id]);

        return $this->render('front/station.html.twig', [
            'station' => $station,

        ]);
    }


    #[Route('/station/{id}', name: 'app_dstation')]
    public function station(StationSkiRepository $stationSkiRepository, $id , PisteRepository $pisteRepository, RemonteeRepository $remonteeRepository): Response
    {
        $station = $stationSkiRepository->findOneBy(array('id' => $id));

        $piste = $pisteRepository->findBy(array('station' => $id));
        $remontee = $remonteeRepository->findBy(array('station' => $id));
        $Hpiste = $pisteRepository->findOneBy(array('station' => $id));
        $Hremontee = $remonteeRepository->findOneBy(array('station' => $id));
        if ($Hpiste != null && $Hremontee != null) {

            $Popen = $Hpiste->getHoraireOuverture();
            $POheure = $Popen->format('H:i:s');

            $Pclose = $Hpiste->getHoraireFermeture();
            $PChour = $Pclose->format('H:i:s');
            $Ropen = $Hremontee->getOpenTime();
            $ROhour = $Ropen->format('H:i:s');

            $Rclose = $Hremontee->getCloseTime();
            $RChour = $Rclose->format('H:i:s');

            return $this->render('front/dstation.html.twig', [
                'station' => $station,
                'piste' => $piste,
                'remontee' => $remontee,
                'POheure' => $POheure,
                'PChour' => $PChour,
                'ROhour' => $ROhour,
                'RChour' => $RChour,

            ]);

        }
        elseif ($Hpiste != null && $Hremontee == null) {
            $Popen = $Hpiste->getHoraireOuverture();
            $POheure = $Popen->format('H:i:s');

            $Pclose = $Hpiste->getHoraireFermeture();
            $PChour = $Pclose->format('H:i:s');
            return $this->render('front/dstation.html.twig', [
                'station' => $station,
                'piste' => $piste,
                'remontee' => $remontee,
                'POheure' => $POheure,
                'PChour' => $PChour,

            ]);
        }
        elseif ($Hpiste == null && $Hremontee != null) {
            $Ropen = $Hremontee->getOpenTime();
            $ROhour = $Ropen->format('H:i:s');

            $Rclose = $Hremontee->getCloseTime();
            $RChour = $Rclose->format('H:i:s');
            return $this->render('front/dstation.html.twig', [
                'station' => $station,
                'piste' => $piste,
                'remontee' => $remontee,
                'ROhour' => $ROhour,
                'RChour' => $RChour,

            ]);
        }
        return $this->render('front/dstation.html.twig', [
            'station' => $station,
            'piste' => $piste,
            'remontee' => $remontee,

        ]);


    }
}
