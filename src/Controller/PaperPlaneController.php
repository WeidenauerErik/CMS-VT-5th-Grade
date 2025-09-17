<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\PaperPlaneData;

final class PaperPlaneController extends AbstractController
{

    #[Route('/round/{roundId}', name: 'round')]
    public function rounds(PaperPlaneData $data, int $roundId = 2): Response //Dependency Injektion
    {
        return $this->render('PaperPlane/round.html.twig', ['rounds' => $data->getRoundsPerID(), 'roundId' => $roundId]);
    }

    #[Route('/', name: 'rounds')]
    public function allRounds(PaperPlaneData $data): Response
    {
        return $this->render('PaperPlane/rounds.html.twig', ['rounds' => $data->getAllRounds()]);
    }

}
