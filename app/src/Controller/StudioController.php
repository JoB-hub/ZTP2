<?php
/**
 * \App\Entity\Studio controller.
 */

namespace App\Controller;

use App\Entity\Studio;
use App\Repository\StudioRepository;
use Knp\Component\Pager\PaginatorInterface;
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
     * Index action.
     *
     * @param Request            $request          HTTP Request
     * @param StudioRepository   $studioRepository Studio repository
     * @param PaginatorInterface $paginator        Paginator
     *
     * @return Response HTTP response
     */
    #[Route(name: 'studio_index', methods: 'GET')]
    public function index(Request $request, StudioRepository $studioRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $studioRepository->queryAll(),
            $request->query->getInt('page', 1),
            StudioRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render('studio/index.html.twig', ['pagination' => $pagination]);
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
