<?php

namespace App\Controller;

use App\Entity\Remontee;
use App\Repository\RemonteeRepository;
use App\Repository\StationSkiRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RemonteeController extends AbstractController
{
    #[Route('/station/{id}/update_remontee', name: 'update_remontee')]
    public function updateRemontee(Request $request, EntityManagerInterface $entityManager, StationSkiRepository $stationSkiRepository  ,Remontee $remontee, $id)
    {
        $status = $request->get('status');
        $block = $request->get('block');

        if ($status === 'open') {
            if ($block) {
                $remontee->setBlockOpen(true);
            } else {
                $remontee->setBlockOpen(false);
            }

            $remontee->setOpen(true);
            $remontee->setClose(false);
        } else {
            if ($block) {
                $remontee->setBlockClose(true);
            } else {
                $remontee->setBlockClose(false);
            }

            $remontee->setOpen(false);
            $remontee->setClose(true);
        }

        $entityManager->flush();

        return $this->redirectToRoute('admin');
    }
}
