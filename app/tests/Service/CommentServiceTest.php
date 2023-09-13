<?php
/**
 * Comment service tests.
 */

namespace Service;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Service\CommentService;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * CommentServiceTest class.
 */
class CommentServiceTest extends TestCase
{
    private CommentRepository $commentRepository;
    private PaginatorInterface $paginator;
    private CommentService $commentService;

    /**
     * Set up.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->commentRepository = $this->createMock(CommentRepository::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);
        $this->commentService = new CommentService($this->commentRepository, $this->paginator);
    }

    /**
     * Test paginated list.
     *
     * @return void
     */
    public function testGetPaginatedList(): void
    {
        $pagination = $this->createMock(PaginationInterface::class);

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

        $result = $this->commentService->getPaginatedList($page);
        $this->assertSame($pagination, $result);
    }

    /**
     * Test save comment.
     *
     * @return void
     */
    public function testSave()
    {
        $comment = $this->createMock(Comment::class);

        $this->commentRepository->expects($this->once())
            ->method('save')
            ->with($comment);

        $this->commentService->save($comment);
    }

    /**
     * Test delete comment.
     *
     * @return void
     */
    public function testDelete()
    {
        $comment = $this->createMock(Comment::class);

        $this->commentRepository->expects($this->once())
            ->method('delete')
            ->with($comment);

        $this->commentService->delete($comment);
    }
}
