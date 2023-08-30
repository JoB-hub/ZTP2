<?php
/**
 * Picture controller.
 */

namespace App\Controller;

use App\Entity\Picture;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PictureController.
 */
#[Route('/picture')]
class PictureController extends AbstractController
{
    /**
     * Index action.
     *
     * @param PictureRepository $pictureRepository Picture repository
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'picture_index',
        methods: 'GET'
    )]
    public function index(PictureRepository $pictureRepository): Response
    {
        $pictures = $pictureRepository->findAll();

        return $this->render(
            'picture/index.html.twig',
            ['pictures' => $pictures]
        );
    }

    /**
     * Show action.
     *
     * @param Picture $picture Picture entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'picture_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Picture $picture): Response
    {
        return $this->render(
            'picture/show.html.twig',
            ['picture' => $picture]
        );
    }
}
