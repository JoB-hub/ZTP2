<?php
/**
 * Studio controller.
 */

namespace App\Controller;

use App\Entity\Studio;
use App\Service\StudioServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StudioController.
 */
#[Route('/studio')]
class StudioController extends AbstractController
{
    /**
     * Studio service.
     */
    private StudioServiceInterface $studioService;

    /**
     * Constructor.
     */
    public function __construct(StudioServiceInterface $studioService)
    {
        $this->studioService = $studioService;
    }


    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'studio_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->studioService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('studio/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Studio $studio Studio
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'studio_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Studio $studio): Response
    {
        return $this->render('studio/show.html.twig', ['studio' => $studio]);
    }
}
