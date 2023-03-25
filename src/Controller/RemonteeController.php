<?php

namespace App\Controller;

use App\Entity\Remontee;
use App\Repository\RemonteeRepository;
use App\Repository\StationSkiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RemonteeController extends AbstractController
{
    #[Route('/update_remontee/{id}', name: 'update_remontee')]
    public function updateRemontee(Request $request, EntityManagerInterface $entityManager, RemonteeRepository $remonteeRepository, $id)
    {
        $status = $request->request->get('status');
        $block = $request->request->get('block');
        $remontee = $remonteeRepository->findBy(['station' => $id]);

foreach ($remontee as $remonte) {
            if ($status === 'open') {
                if ($block) {
                    $remonte->setBlock(true);
                } else {
                    $remonte->setBlock(false);
                }

                $remonte->setOpen(true);

            }
            else {
                if ($block) {
                    $remonte->setBlock(true);
                } else {
                    $remonte->setBlock(false);
                }

                $remonte->setOpen(false);


            }

            $entityManager->flush();
        }

        return $this->redirectToRoute('station_edit', ['id' => $id]);
    }
}
