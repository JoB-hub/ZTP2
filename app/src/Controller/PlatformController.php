<?php
/**
 * \App\Entity\Platform controller.
 */

namespace App\Controller;

use App\Entity\Platform;
use App\Repository\PlatformRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlatformController.
 */
#[Route('/platform')]
class PlatformController extends AbstractController
{
    /**
     * Index action.
     *
     * @param PlatformRepository $platformRepository Platform repository
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'platform_index',
        methods: 'GET'
    )]
    public function index(PlatformRepository $platformRepository): Response
    {
        $platforms = $platformRepository->findAll();

        return $this->render(
            'platform/index.html.twig',
            ['platforms' => $platforms]
        );
    }

    /**
     * Show action.
     *
     * @param Platform $platform Platform entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'platform_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Platform $platform): Response
    {
        return $this->render(
            'platform/show.html.twig',
            ['platform' => $platform]
        );
    }
}
