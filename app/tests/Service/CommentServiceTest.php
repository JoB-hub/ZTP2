<?php

namespace App\Tests\Service;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Service\CommentService;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

class CommentServiceTest extends TestCase
{
    private CommentRepository $commentRepository;
    private PaginatorInterface $paginator;
    private CommentService $commentService;

    protected function setUp(): void
    {
        $this->commentRepository = $this->createMock(CommentRepository::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);
        $this->commentService = new CommentService($this->commentRepository, $this->paginator);
    }

    public function testGetPaginatedList(): void
    {
        // Create a mock for PaginationInterface
        $pagination = $this->createMock(PaginationInterface::class);

        // Define expected parameters and return value for paginator->paginate()
        $page = 1;
        $itemsPerPage = CommentRepository::PAGINATOR_ITEMS_PER_PAGE;
        $this->paginator->expects($this->once())
            ->method('paginate')
            ->with(
                $this->commentRepository->queryAll(),
                $page,
                $itemsPerPage
            )
            ->willReturn($pagination);

        // Call the getPaginatedList method and assert the returned value
        $result = $this->commentService->getPaginatedList($page);
        $this->assertSame($pagination, $result);
    }

    public function testSave()
    {
        // Mock a Comment entity
        $comment = $this->createMock(Comment::class);

        $this->commentRepository->expects($this->once())
            ->method('save')
            ->with($comment);

        $this->commentService->save($comment);
    }

    public function testDelete()
    {
        // Mock a Comment entity
        $comment = $this->createMock(Comment::class);

        $this->commentRepository->expects($this->once())
            ->method('delete')
            ->with($comment);

        $this->commentService->delete($comment);
    }

    // Add more test cases as needed for other methods in CommentService
}
