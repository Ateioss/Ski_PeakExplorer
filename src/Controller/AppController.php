<?php

namespace App\Controller;

use App\Entity\Piste;
use App\Form\FdomaineType;
use App\Repository\PisteRepository;
use App\Repository\StationSkiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Gdomaine;
use App\Repository\GdomaineRepository;
use App\Repository\RemonteeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
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
        return $this->render('app/remontee.html.twig', [
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


    #[Route('/automatic/{id}', name: 'app_auto')]
    public function auto(PisteRepository $pisteRepository, RemonteeRepository $remonteeRepository, $id, ManagerRegistry $managerRegistry): Response
    {
        date_default_timezone_set('Europe/Paris');
        $time = date("G:i:s");


        $pistes = $pisteRepository->findAll();
        $remontees = $remonteeRepository->findAll();


        foreach ($pistes as $piste) {

            $Hpiste = $pisteRepository->findOneBy(array('station' => $piste->getStation()));

            $Popen = $Hpiste->getHoraireOuverture();
            $POheure = $Popen->format('H:i:s');

            $Pclose = $Hpiste->getHoraireFermeture();
            $PChour = $Pclose->format('H:i:s');
            if ($time >= $POheure && $time <= $PChour ){
                return $this->json(true);
            }


            if ($time >= $POheure && $time < $PChour && $piste->getOuverture() == false && $piste->getBlock() == false) {
                $piste->setOuverture(true);

            } elseif ($time > $PChour && $piste->getOuverture() == true && $piste->getBlock() == false){
                $piste->setOuverture(false);

            }


            $managerRegistry->getManager()->flush();

        }



        return $this->redirectToRoute('app_edit', ["id" => $id]);
    }

    #[Route('/edit/{id}', name: 'app_edit')]
    public function edit(StationSkiRepository $stationSkiRepository, $id): Response
    {

        $station = $stationSkiRepository->findBy(array('domain' => $id));
        return $this->render('app/edit.html.twig', [
            'station' => $station,
            'id' => $id,

        ]);
    }

    #[Route('/edit/station/{id}', name: 'station_edit')]

    public function Sedit(StationSkiRepository $stationSkiRepository, $id, PisteRepository $pisteRepository, RemonteeRepository $remonteeRepository, Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createFormBuilder()
            ->add('piste_status', ChoiceType::class, [
                'choices' => [
                    'Ouvrir les pistes' => 'open',
                    'Fermer les pistes' => 'close',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('block_status', ChoiceType::class, [
                'choices' => [
                    'Débloquer les pistes' => 'unblock',
                    'Bloquer les pistes' => 'block',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->getForm();

        $station = $stationSkiRepository->findOneBy(array('id' => $id));

        $piste = $pisteRepository->findBy(array('station' => $id));
        $remontee = $remonteeRepository->findBy(array('station' => $id));
        $Hpiste = $pisteRepository->findOneBy(array('station' => $id));
        $Hremontee = $remonteeRepository->findOneBy(array('station' => $id));



        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $status = $form->get('piste_status')->getData();
            $blockStatus = $form->get('block_status')->getData();

            foreach ($piste as $pistes) {
                if ($status == 'open') {
                    $pistes->setOuverture(true);
                } else {
                    $pistes->setOuverture(false);
                }

                if ($blockStatus == 'block') {
                    $pistes->setBlock(true);
                } else {
                    $pistes->setBlock(false);
                }

                $entityManager->persist($pistes);
            }
            $entityManager->flush();
        }
        if ($Hpiste != null && $Hremontee != null) {

            $Popen = $Hpiste->getHoraireOuverture();
            $POheure = $Popen->format('H:i:s');

            $Pclose = $Hpiste->getHoraireFermeture();
            $PChour = $Pclose->format('H:i:s');
            $Ropen = $Hremontee->getOpenTime();
            $ROhour = $Ropen->format('H:i:s');

            $Rclose = $Hremontee->getCloseTime();
            $RChour = $Rclose->format('H:i:s');
            return $this->render('app/Sedit.html.twig', [
                'station' => $station,
                'piste' => $piste,
                'remontee' => $remontee,
                'POheure' => $POheure,
                'PChour' => $PChour,
                'ROhour' => $ROhour,
                'RChour' => $RChour,
                'form' => $form->createView(),
            ]);
        }

        elseif ($Hpiste != null && $Hremontee == null) {
            $Popen = $Hpiste->getHoraireOuverture();
            $POheure = $Popen->format('H:i:s');

            $Pclose = $Hpiste->getHoraireFermeture();
            $PChour = $Pclose->format('H:i:s');
            return $this->render('app/Sedit.html.twig', [
                'station' => $station,
                'piste' => $piste,
                'remontee' => $remontee,
                'POheure' => $POheure,
                'PChour' => $PChour,
                'form' => $form->createView(),
            ]);
        }
        elseif ($Hpiste == null && $Hremontee != null) {
            $Ropen = $Hremontee->getOpenTime();
            $ROhour = $Ropen->format('H:i:s');

            $Rclose = $Hremontee->getCloseTime();
            $RChour = $Rclose->format('H:i:s');
            return $this->render('app/Sedit.html.twig', [
                'station' => $station,
                'piste' => $piste,
                'remontee' => $remontee,
                'ROhour' => $ROhour,
                'RChour' => $RChour,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('app/Sedit.html.twig', [
            'station' => $station,
            'piste' => $piste,
            'remontee' => $remontee,
            'form' => $form->createView(),
        ]);

    }


    #[Route('/domaine', name: 'app_domaine')]
    public function domaine(GdomaineRepository $gdomaineRepository): Response
    {
        $domaine = $gdomaineRepository->findAll();
        $user = $this->getUser();
        $Ruser = $this->getUser()->getRoles()[0];
        if ($Ruser == "ROLE_ADMIN") {
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
    public function Ndomaine(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {

        $fdomaine = new Gdomaine();
        $form = $this->createForm(FdomaineType::class, $fdomaine);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $imagefile = $form->get('image')->getData();

            if ($imagefile) {
                $originalFilename = pathinfo($imagefile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imagefile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imagefile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $fdomaine->setImage($newFilename);
            }

            $em->persist($fdomaine);
            $em->flush();

            return $this->redirectToRoute('app_domaine');
        }

        return $this->render('app/fdomaine.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
