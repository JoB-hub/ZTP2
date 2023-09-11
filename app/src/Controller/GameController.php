<?php
/**
 * Game controller.
 */

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Pic;
use App\Form\Type\GameType;
use App\Service\GameServiceInterface;
use App\Service\PicServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

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
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Pic service.
     */
    private PicServiceInterface $picService;

    /**
     * Constructor.
     *
     * @param GameServiceInterface $gameService Game service
     * @param TranslatorInterface  $translator  Translator
     */
    public function __construct(GameServiceInterface $gameService, TranslatorInterface $translator, PicServiceInterface $picService)
    {
        $this->gameService = $gameService;
        $this->translator = $translator;
        $this->picService = $picService;
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
        methods: 'GET|POST|DELETE',
    )]
    public function show(Game $game): Response
    {
        return $this->render(
            'game/show.html.twig',
            ['game' => $game]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route('/create', name: 'game_create', methods: 'GET|POST')]
    public function create(Request $request): Response
    {
        $user = $this->getUser();
        $game = new Game();
        $pic = new Pic();
        $game->setAuthor($user);
        $form = $this->createForm(
            GameType::class,
            $game,
            ['action' => $this->generateUrl('game_create')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();
            $this->picService->create(
                $file,
                $pic,
                $game
            );
            $this->gameService->save($game);
            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('game_index');
        }

        return $this->render(
            'game/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Game    $game    Game entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'game_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Game $game): Response
    {
        $form = $this->createForm(
            GameType::class,
            $game,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('game_edit', ['id' => $game->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->gameService->save($game);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('game_index');
        }

        return $this->render(
            'game/edit.html.twig',
            [
                'form' => $form->createView(),
                'game' => $game,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Game    $game    Game entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'game_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Game $game): Response
    {
        $form = $this->createForm(
            FormType::class,
            $game,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('game_delete', ['id' => $game->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->gameService->delete($game);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('game_index');
        }

        return $this->render(
            'game/delete.html.twig',
            [
                'form' => $form->createView(),
                'game' => $game,
            ]
        );
    }
}
