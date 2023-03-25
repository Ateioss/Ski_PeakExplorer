<?php

namespace App\Controller;

use App\Entity\Piste;
use App\Repository\PisteRepository;
use App\Repository\StationSkiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Gdomaine;
use App\Repository\GdomaineRepository;
use App\Repository\RemonteeRepository;
use Doctrine\Persistence\ManagerRegistry;
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


    #[Route('/piste', name: 'app_piste')]
    public function piste(Request $request, PisteRepository $pisteRepository): Response
    {
        $pistes = $pisteRepository->findAll();

        return $this->render('app/piste.html.twig', [
            'controller_name' => 'AppController',
            'pistes' => $pistes,
        ]);
    }



    #[Route('/automatic{id}', name: 'app_auto')]
    public function auto(PisteRepository $pisteRepository, RemonteeRepository $remonteeRepository, $id): Response
    {
        $time = date("h:m:s");
        $pistes = $pisteRepository->findAll();
        $remontees = $remonteeRepository->findAll();
        foreach ($pistes as $piste) {
            if ($time >= $piste->getHoraireOuverture()&& $piste->getOuverture() == false && $piste->getBlock() == false) {
                $piste->setOuverture(true);
            }
            elseif ($time >= $piste->getHoraireFermeture() && $piste->getOuverture() == true && $piste->getBlock() == false){
                $piste->setOuverture(false);
            }
        }
        foreach ($remontees as $remontee) {
            if ($time >= $remontee->getOpenTime() && $remontee->getOpen() == false && $piste->getBlock() == false){
                $remontee->setOpen(true);
            }
            elseif ($time >= $remontee->getCloseTime() && $remontee->getOpen() == true && $piste->getBlock() == false){
                $remontee->setOpen(false);
            }
        }

        return $this->redirectToRoute('app_edit', ['id' => $id]);
    }

    #[Route('/edit{id}', name: 'app_edit')]
    public function edit(StationSkiRepository $stationSkiRepository, $id): Response
    {
        $station = $stationSkiRepository->findBy(array('domain' => $id));
        return $this->render('app/edit.html.twig', [
            'station' => $station,
            'id' => $id,
        ]);
    }

    #[Route('/edit/station/{id}', name: 'station_edit')]
    public function Sedit(StationSkiRepository $stationSkiRepository, $id): Response
    {
        $station = $stationSkiRepository->findOneBy(array('id'=>$id));

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
            'admin' => false
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
