<?php
/**
 * \App\Entity\Platform controller.
 */

namespace App\Controller;

use App\Entity\Platform;
use App\Repository\PlatformRepository;
use Knp\Component\Pager\PaginatorInterface;
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
     * Index action.
     *
     * @param Request            $request            HTTP Request
     * @param PlatformRepository $platformRepository Platform repository
     * @param PaginatorInterface $paginator          Paginator
     *
     * @return Response HTTP response
     */
    #[Route(name: 'platform_index', methods: 'GET')]
    public function index(Request $request, PlatformRepository $platformRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $platformRepository->queryAll(),
            $request->query->getInt('page', 1),
            PlatformRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render('platform/index.html.twig', ['pagination' => $pagination]);
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
