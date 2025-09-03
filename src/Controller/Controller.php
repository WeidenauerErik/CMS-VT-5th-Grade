<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('/round/{roundId}', name: 'round')]
    public function rounds(int $roundId): Response
    {
        $rounds = [
            ['paperPlaneModel' => 'Super Shuttle 3000', 'travelledDistance' => '3001m', 'flightDuration' => '21min', 'particpantName' => 'Andreas Fink', 'date' => 'Oktober'],
            ['paperPlaneModel' => 'Super Dupa Shuttle 5000', 'travelledDistance' => '5102m', 'flightDuration' => '32min', 'particpantName' => 'Martin Fitz', 'date' => 'Oktober'],
            ['paperPlaneModel' => 'Super Exponential Shuttle 10000', 'travelledDistance' => '12m', 'flightDuration' => '42min', 'particpantName' => 'Sabine Schlechta', 'date' => 'Oktober'],
            ['paperPlaneModel' => 'Donald Duck Shuttle 700', 'travelledDistance' => '701m', 'flightDuration' => '12min', 'particpantName' => 'Donald Duck', 'date' => 'Oktober'],
            ['paperPlaneModel' => 'Skilldisplay Shuttle 1000000', 'travelledDistance' => '1 000 000m', 'flightDuration' => '2ms', 'particpantName' => 'Franz und Florian', 'date' => 'Oktober'],
            ];

        return $this->render('round.html.twig', ['rounds' => $rounds, 'roundId' => $roundId]);
    }

    #[Route('/rounds', name: 'rounds')]
    public function allRounds(): Response
    {
        $rounds = [
            ['id' => 1, 'name' => 'Erste Runde'],
            ['id' => 2, 'name' => 'Zweite Runde'],
            ['id' => 3, 'name' => 'Dritte Runde'],
        ];

        return $this->render('rounds.html.twig', ['rounds' => $rounds]);
    }
}
