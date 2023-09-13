<?php

namespace App\Tests\Service;

use App\Entity\Genre;
use App\Service\GenreService;
use App\Service\PlatformService;
use App\Entity\Platform;
use App\Repository\PlatformRepository;
use Faker\Container\Container;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class PlatformServiceTest extends TestCase
{
    private PlatformRepository $platformRepository;
    private PaginatorInterface $paginator;
    private PlatformService $platformService;
    private GenreService $genreService;

    private \Symfony\Component\DependencyInjection\Container $container;

    private ?EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->platformRepository = $this->createMock(PlatformRepository::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);

        $this->platformService = new PlatformService($this->platformRepository, $this->paginator);
    }

    public function testGetPaginatedList(): void
    {
        $pagination = $this->createMock(PaginationInterface::class);

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

        $result = $this->platformService->getPaginatedList($page);
        $this->assertSame($pagination, $result);
    }

    public function testSave(): void
    {
        $platform = $this->createMock(Platform::class);

        $this->platformRepository->expects($this->once())
        ->method('save')
        ->with($platform);

        $this->platformService->save($platform);
    }

    public function testDelete(): void
    {
        $platform = $this->createMock(Platform::class);

        $this->platformRepository->expects($this->once())
        ->method('delete')
        ->with($platform);

        $this->platformService->delete($platform);
    }

    public function testCanBeDeleted(): void
    {
        $platform = $this->createMock(Platform::class);

        $expectedResult = true;

        $result = $this->platformService->canBeDeleted($platform);
        $this->assertSame($expectedResult, $result);
    }
}
