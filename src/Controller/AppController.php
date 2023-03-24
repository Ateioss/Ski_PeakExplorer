<?php

namespace App\Controller;

use App\Entity\Gdomaine;
use App\Entity\Station;
use App\Repository\GdomaineRepository;
use App\Repository\PisteRepository;
use App\Repository\RemonteeRepository;
use App\Repository\StationRepository;
use App\Repository\StationSkiRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
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
    #[Route('/edit{id}', name: 'app_edit')]
    public function edit(StationSkiRepository $stationSkiRepository, $id): Response
    {
        $station = $stationSkiRepository->findBy(array('domaine' => $id));
        return $this->render('app/edit.html.twig', [
            'station' => $station,
        ]);
    }
    #[Route('/edit/station/{id}', name: 'station_edit')]
    public function Sedit(StationSkiRepository $stationSkiRepository, $id): Response
    {
        $station = $stationSkiRepository->findOneBy($id);
        return $this->render('app/Sedit.html.twig', [
            'station' => $station,
        ]);
    }
    #[Route('/domaine', name: 'app_domaine')]
    public function domaine(GdomaineRepository $gdomaineRepository): Response
    {
        $domaine = $gdomaineRepository->findAll();
        $user = $this->getUser();
        $Ruser = $this->getUser()->getRoles()[0];
        if ($Ruser == "ROLE_ADMIN"){
            return $this->render('app/domaine.html.twig', [
                'domaine' => $domaine,
                'admin' => true
            ]);
        }

        return $this->render('app/domaine.html.twig', [
            'domaine' => $domaine,
        ]);
    }

    #[Route('/Cdomaine', name: 'app_CDomaine', methods: ['GET', 'POST'])]
    public function Cdomaine(ManagerRegistry $managerRegistry): Response
    {
        $domaine = new Gdomaine();
        $name = $_POST['name'];
        $logo = $_POST['logo'];
        $domaine->setName($name);
        $domaine->setImage($logo);
        $managerRegistry->getManager()->persist($domaine);
        $managerRegistry->getManager()->flush();
        return $this->redirectToRoute('app_domaine');
    }

    #[Route('/Fdomaine', name: 'domaine_new')]
    public function Ndomaine(ManagerRegistry $managerRegistry): Response
    {

        return $this->render('app/fdomaine.html.twig', [
            'domaine' => 'coucou',
        ]);
    }


}
