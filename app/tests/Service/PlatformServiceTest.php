<?php

namespace App\Tests\Service;

use App\Service\PlatformService;
use App\Entity\Platform;
use App\Repository\PlatformRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

class PlatformServiceTest extends TestCase
{
    private PlatformRepository $platformRepository;
    private PaginatorInterface $paginator;
    private PlatformService $platformService;

    public function setUp(): void
    {
        // Create mock instances of PlatformRepository and PaginatorInterface
        $this->platformRepository = $this->createMock(PlatformRepository::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);

        // Create an instance of PlatformService with the mock dependencies
        $this->platformService = new PlatformService($this->platformRepository, $this->paginator);
    }

    public function testGetPaginatedList(): void
    {
        // Create a mock for PaginationInterface
        $pagination = $this->createMock(PaginationInterface::class);

        // Define expected parameters and return value for paginator->paginate()
        $page = 1;
        $itemsPerPage = PlatformRepository::PAGINATOR_ITEMS_PER_PAGE;
        $this->paginator->expects($this->once())
            ->method('paginate')
            ->with(
                $this->platformRepository->queryAll(),
                $page,
                $itemsPerPage
            )
            ->willReturn($pagination);

        // Call the getPaginatedList method and assert the returned value
        $result = $this->platformService->getPaginatedList($page);
        $this->assertSame($pagination, $result);
    }

    public function testSave(): void
    {
        // Create a mock Platform entity
        $platform = $this->createMock(Platform::class);

        // Define expected method call to platformRepository->save()
        $this->platformRepository->expects($this->once())
        ->method('save')
        ->with($platform);

        // Call the save method and assert no exceptions are thrown
        $this->platformService->save($platform);
    }

    public function testDelete(): void
    {
        // Create a mock Platform entity
        $platform = $this->createMock(Platform::class);

        // Define expected method call to platformRepository->delete()
        $this->platformRepository->expects($this->once())
        ->method('delete')
        ->with($platform);

        // Call the delete method and assert no exceptions are thrown
        $this->platformService->delete($platform);
    }

    public function testCanBeDeleted(): void
    {
        // Create a mock Platform entity (you can customize its properties as needed)
        $platform = $this->createMock(Platform::class);

        // Define expected result (in this example, always true)
        $expectedResult = true;

        // Call the canBeDeleted method and assert the result
        $result = $this->platformService->canBeDeleted($platform);
        $this->assertSame($expectedResult, $result);
    }
}
