<?php
/**
 * Game controller.
 */

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @param GameRepository $gameRepository Game repository
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'game_index',
        methods: 'GET'
    )]
    public function index(GameRepository $gameRepository): Response
    {
        $games = $gameRepository->findAll();

        return $this->render(
            'game/index.html.twig',
            ['games' => $games]
        );
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
