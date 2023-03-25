<?php

namespace App\Controller;

use App\Entity\Piste;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PisteController extends AbstractController
{
    #[Route('/pistes', name: 'piste')]
    public function pistes(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pistes = $entityManager->getRepository(Piste::class)->findAll();
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


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $status = $form->get('piste_status')->getData();
            $blockStatus = $form->get('block_status')->getData();

            foreach ($pistes as $piste) {
                if ($status == 'open') {
                    $piste->setOuverture(true);
                } else {
                    $piste->setOuverture(false);
                }

                if ($blockStatus == 'block') {
                    $piste->setBlock(true);
                } else {
                    $piste->setBlock(false);
                }

                $entityManager->persist($piste);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Les pistes ont été mises à jour avec succès');
            return $this->redirectToRoute('pistes');
        }


        return $this->render('app/Sedit.html.twig', [

            'form' => $form->createView(),
        ]);
    }


}
