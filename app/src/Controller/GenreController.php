<?php
/**
 * Genre controller.
 */

namespace App\Controller;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GenreController.
 */
#[Route('/genre')]
class GenreController extends AbstractController
{
    /**
     * Index action.
     *
     * @param GenreRepository $genreRepository Genre repository
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'genre_index',
        methods: 'GET'
    )]
    public function index(GenreRepository $genreRepository): Response
    {
        $genres = $genreRepository->findAll();

        return $this->render(
            'genre/index.html.twig',
            ['genres' => $genres]
        );
    }

    /**
     * Show action.
     *
     * @param Genre $genre Genre entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'genre_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Genre $genre): Response
    {
        return $this->render(
            'genre/show.html.twig',
            ['genre' => $genre]
        );
    }
}
