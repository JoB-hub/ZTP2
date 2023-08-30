<?php
/**
 * Comment controller.
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommentController.
 */
#[Route('/comment')]
class CommentController extends AbstractController
{
    /**
     * Index action.
     *
     * @param CommentRepository $commentRepository Comment repository
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'comment_index',
        methods: 'GET'
    )]
    public function index(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findAll();

        return $this->render(
            'comment/index.html.twig',
            ['comments' => $comments]
        );
    }

    /**
     * Show action.
     *
     * @param Comment $comment Comment entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'comment_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Comment $comment): Response
    {
        return $this->render(
            'comment/show.html.twig',
            ['comment' => $comment]
        );
    }
}
