<?php
/**
 * \App\Entity\Studio controller.
 */

namespace App\Controller;

use App\Entity\Studio;
use App\Repository\StudioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StudioController.
 */
#[Route('/studio')]
class StudioController extends AbstractController
{
    /**
     * Index action.
     *
     * @param StudioRepository $studioRepository Studio repository
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'studio_index',
        methods: 'GET'
    )]
    public function index(StudioRepository $studioRepository): Response
    {
        $studios = $studioRepository->findAll();

        return $this->render(
            'studio/index.html.twig',
            ['studios' => $studios]
        );
    }

    /**
     * Show action.
     *
     * @param Studio $studio Studio entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'studio_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Studio $studio): Response
    {
        return $this->render(
            'studio/show.html.twig',
            ['studio' => $studio]
        );
    }
}
