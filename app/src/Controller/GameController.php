<?php
/**
 * Game controller.
 */

namespace App\Controller;

use App\Entity\Game;
use App\Service\GameServiceInterface;
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
     * Game service.
     */
    private GameServiceInterface $gameService;

    /**
     * Constructor.
     */
    public function __construct(GameServiceInterface $gameService)
    {
        $this->gameService = $gameService;
    }
    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'game_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->gameService->getPaginatedList(
            $request->query->getInt('page', 1)
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
