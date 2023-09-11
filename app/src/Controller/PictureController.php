<?php
/**
 * Picture controller.
 */

namespace App\Controller;

use App\Entity\Picture;
use App\Service\PictureServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PictureController.
 */
#[Route('/picture')]
class PictureController extends AbstractController
{
    /**
     * Picture service.
     */
    private PictureServiceInterface $pictureService;

    /**
     * Constructor.
     */
    public function __construct(PictureServiceInterface $pictureService)
    {
        $this->pictureService = $pictureService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'picture_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->pictureService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('picture/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Picture $picture Picture
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'picture_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Picture $picture): Response
    {
        return $this->render('picture/show.html.twig', ['picture' => $picture]);
    }
}
