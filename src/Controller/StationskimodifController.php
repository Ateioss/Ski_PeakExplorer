<?php

namespace App\Controller;

use App\Form\StationSkiType;
use App\Repository\StationSkiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class StationskimodifController extends AbstractController
{
    #[Route('/stationskimodif/{id}', name: 'app_stationskimodif')]
    public function index(Request $request,StationSkiRepository $stationSkiRepository,EntityManagerInterface $em, SluggerInterface $slugger, $id): Response
    {
        $station = $stationSkiRepository->FindOneBy(array("id" => $id));
        $form = $this->createForm(StationSkiType::class, $station);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imagefile = $form->get('image')->getData();

            if ($imagefile) {
                $originalFilename = pathinfo($imagefile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imagefile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imagefile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $station->setImage($newFilename);
            }
            $modifb =$form->get('description')->getData();
            $station->setDescription($modifb);

            $em->persist($station);
            $em->flush();

            $this->addFlash('success', 'Les pistes ont été mises à jour avec succès');
            return $this->redirectToRoute('station_edit', [
                'id' => $id,
            ]);
        }
        return $this->render('stationskimodif/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
