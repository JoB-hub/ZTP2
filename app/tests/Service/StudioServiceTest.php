<?php
/**
 * Studio service tests.
 */

namespace Service;

use App\Entity\Studio;
use App\Repository\GameRepository;
use App\Repository\StudioRepository;
use App\Service\StudioService;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * GameServiceTest class.
 */
class StudioServiceTest extends TestCase
{
    private StudioRepository $studioRepository;
    private GameRepository $gameRepository;
    private PaginatorInterface $paginator;
    private StudioService $studioService;

    /**
     * Set up.
     * @return void
     */
    protected function setUp(): void
    {
        $this->studioRepository = $this->createMock(StudioRepository::class);
        $this->gameRepository = $this->createMock(GameRepository::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);
        $this->studioService = new StudioService($this->studioRepository, $this->paginator, $this->gameRepository);
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
        $itemsPerPage = StudioRepository::PAGINATOR_ITEMS_PER_PAGE;
        $this->paginator->expects($this->once())
            ->method('paginate')
            ->with(
                $this->studioRepository->queryAll(),
                $page,
                $itemsPerPage
            )
            ->willReturn($pagination);

        $result = $this->studioService->getPaginatedList($page);
        $this->assertSame($pagination, $result);
    }

    /**
     * Test save studio.
     *
     * @return void
     */
    public function testSave()
    {
        $studio = $this->createMock(Studio::class);

        $this->studioRepository->expects($this->once())
            ->method('save')
            ->with($studio);

        $this->studioService->save($studio);
    }

    /**
     * Test delete studio.
     *
     * @return void
     */
    public function testDelete()
    {
        $studio = $this->createMock(Studio::class);

        $this->studioRepository->expects($this->once())
            ->method('delete')
            ->with($studio);

        $this->studioService->delete($studio);
    }

    /**
     * Test can be deleted.
     *
     * @return void
     */
    public function testCanBeDeleted()
    {
        $studio = $this->createMock(Studio::class);

        $this->gameRepository->expects($this->once())
            ->method('countByStudio')
            ->with($studio)
            ->willReturn(0);

        $result = $this->studioService->canBeDeleted($studio);
        $this->assertTrue($result);
    }

    /**
     * Test cannot be deleted.
     *
     * @return void
     */
    public function testCannotBeDeleted()
    {
        $studio = $this->createMock(Studio::class);

        $this->gameRepository->expects($this->once())
            ->method('countByStudio')
            ->with($studio)
            ->willThrowException(new NoResultException());

        $result = $this->studioService->canBeDeleted($studio);
        $this->assertFalse($result);
    }
}
