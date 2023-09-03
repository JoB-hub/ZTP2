<?php
/**
 * Platform controller.
 */

namespace App\Controller;

use App\Entity\Platform;
use App\Service\PlatformServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlatformController.
 */
#[Route('/platform')]
class PlatformController extends AbstractController
{
    /**
     * Platform service.
     */
    private PlatformServiceInterface $platformService;

    /**
     * Constructor.
     */
    public function __construct(PlatformServiceInterface $platformService)
    {
        $this->platformService = $platformService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'platform_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->platformService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('platform/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Platform $platform Platform
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'platform_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Platform $platform): Response
    {
        return $this->render('platform/show.html.twig', ['platform' => $platform]);
    }
}
