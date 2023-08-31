<?php
/**
 * Game controller.
 */

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameController.
 */
#[Route('/game')]
class GameController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request            $request        HTTP Request
     * @param GameRepository     $gameRepository Game repository
     * @param PaginatorInterface $paginator      Paginator
     *
     * @return Response HTTP response
     */
    #[Route(name: 'game_index', methods: 'GET')]
    public function index(Request $request, GameRepository $gameRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $gameRepository->queryAll(),
            $request->query->getInt('page', 1),
            GameRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render('game/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Game $game Game entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'game_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Game $game): Response
    {
        return $this->render(
            'game/show.html.twig',
            ['game' => $game]
        );
    }
}
