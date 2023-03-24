<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\StationSki;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\StationSkiType;

class StationskiTypeController extends AbstractController
{
    #[Route('/stationski/type', name: 'app_stationski_type')]


    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $notification = null;

        $stationSki = new StationSki();
        $form = $this->createForm(StationSkiType::class, $stationSki);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            /*$uploadedFile = $form['image']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';

            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename,*/

            $em->persist($stationSki);
            $em->flush();

            $notification = "votre formulaire a bien été soumis";
            $this->addFlash('success',$notification);

            return $this->redirectToRoute('app_index');
        }



        return $this->render('stationski_type/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }




}
