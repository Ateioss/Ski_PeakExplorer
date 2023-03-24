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

    /*public static function getEntityFqcn(): string
    {
        return StationSkiType::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            ImageField::new('image')
                ->setBasePath('uploads')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
        ];
    }*/
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $notification = null;

        $stationSki = new StationSki();
        $form = $this->createForm(StationSkiType::class, $stationSki);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
