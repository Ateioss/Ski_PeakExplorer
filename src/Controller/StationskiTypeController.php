<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\StationSki;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Form\StationSkiType;

class StationskiTypeController extends AbstractController
{
    #[Route('/stationski/type', name: 'app_stationski_type')]

    public function index(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $notification = null;

        $stationSki = new StationSki();
        $form = $this->createForm(StationSkiType::class, $stationSki);
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
                $stationSki->setImage($newFilename);
            }

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
