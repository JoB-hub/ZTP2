<?php
use App\Entity\Studio;
use App\Repository\GameRepository;
use App\Repository\StudioRepository;
use App\Service\StudioService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

class StudioServiceTest extends TestCase
{
    private $studioRepository;
    private $gameRepository;
    private $paginator;
    private $studioService;

    protected function setUp(): void
    {
        $this->studioRepository = $this->createMock(StudioRepository::class);
        $this->gameRepository = $this->createMock(GameRepository::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);
        $this->studioService = new StudioService($this->studioRepository, $this->paginator, $this->gameRepository);
    }

    public function testGetPaginatedList(): void
    {
        // Create a mock for PaginationInterface
        $pagination = $this->createMock(PaginationInterface::class);

        // Define expected parameters and return value for paginator->paginate()
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

        // Call the getPaginatedList method and assert the returned value
        $result = $this->studioService->getPaginatedList($page);
        $this->assertSame($pagination, $result);
    }

    public function testSave()
    {
        // Mock a Studio entity
        $studio = $this->createMock(Studio::class);

        $this->studioRepository->expects($this->once())
            ->method('save')
            ->with($studio);

        $this->studioService->save($studio);
    }

    public function testDelete()
    {
        // Mock a Studio entity
        $studio = $this->createMock(Studio::class);

        $this->studioRepository->expects($this->once())
            ->method('delete')
            ->with($studio);

        $this->studioService->delete($studio);
    }

    public function testCanBeDeleted()
    {
        // Mock a Studio entity
        $studio = $this->createMock(Studio::class);

        // Mock the behavior of GameRepository
        $this->gameRepository->expects($this->once())
            ->method('countByStudio')
            ->with($studio)
            ->willReturn(0);

        // Verify that the result is true since there are no associated games
        $result = $this->studioService->canBeDeleted($studio);
        $this->assertTrue($result);
    }

    public function testCannotBeDeleted()
    {
        // Mock a Studio entity
        $studio = $this->createMock(Studio::class);

        // Mock the behavior of GameRepository
        $this->gameRepository->expects($this->once())
            ->method('countByStudio')
            ->with($studio)
            ->willThrowException(new NoResultException());

        // Verify that the result is false due to an exception indicating associated games
        $result = $this->studioService->canBeDeleted($studio);
        $this->assertFalse($result);
    }

    // Add more test cases as needed for other methods in StudioService
}
