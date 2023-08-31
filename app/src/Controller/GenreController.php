<?php
/**
 * Genre controller.
 */

namespace App\Controller;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request            $request         HTTP Request
     * @param GenreRepository    $genreRepository Genre repository
     * @param PaginatorInterface $paginator       Paginator
     *
     * @return Response HTTP response
     */
    #[Route(name: 'genre_index', methods: 'GET')]
    public function index(Request $request, GenreRepository $genreRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $genreRepository->queryAll(),
            $request->query->getInt('page', 1),
            GenreRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render('genre/index.html.twig', ['pagination' => $pagination]);
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
