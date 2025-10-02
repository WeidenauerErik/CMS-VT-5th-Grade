<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Context\Encoder\CsvEncoderContextBuilder;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/movie')]
final class MovieController extends AbstractController
{
    #[Route(name: 'app_movie_index', methods: ['GET'])]
    public function index(Request $request, MovieRepository $movieRepository): Response
    {
        $search = $request->query->get('search'); // Suchparameter aus GET
        $data = $movieRepository->findAll();

        // optional nach Search filtern
        if ($search) {
            $data = array_filter($data, function ($movie) use ($search) {
                return str_contains(strtolower($movie->getName()), strtolower($search));
            });
        }

        // alphabetisch nach Name sortieren
        usort($data, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });

        return $this->render('movie/index.html.twig', [
            'movies' => $data,
            'search' => $search,
        ]);
    }

    #[Route('/json', name: 'app_movie_index_json', methods: ['GET'])]
    public function indexJson(MovieRepository $movieRepository, SerializerInterface $serializer): Response
    {
        $data = $movieRepository->findAll();
        $jsonData = array_map(fn(Movie $movie) =>  [
            'id' => $movie->getId(),
            'name' => $movie->getName(),
            'year' => $movie->getYear(),
        ], $data);
        return $this->json($jsonData, Response::HTTP_OK);
    }

    #[Route('/csv', name: 'app_movie_index_csv', methods: ['GET'])]
    public function indexCSV(MovieRepository $movieRepository, SerializerInterface $serializer): Response
    {
        $data = $movieRepository->findAll();

        $contextBuilder = new ObjectNormalizerContextBuilder()
            ->withContext($data)
            ->withGroups(['csv']);

        $contextBuilder = new CsvEncoderContextBuilder()
            ->withContext($contextBuilder)
            ->withDelimiter(';');

        return new Response($serializer->serialize($data, 'csv', $contextBuilder->toArray()));
    }

    #[Route('/new', name: 'app_movie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($movie);
            $entityManager->flush();

            return $this->redirectToRoute('app_movie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie/new.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movie_show', methods: ['GET'])]
    public function show(Movie $movie): Response
    {
        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_movie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_movie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movie_delete', methods: ['POST'])]
    public function delete(Request $request, Movie $movie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $movie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($movie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_movie_index', [], Response::HTTP_SEE_OTHER);
    }


}
