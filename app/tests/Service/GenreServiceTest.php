<?php

namespace App\Tests\Service;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use App\Repository\GameRepository;
use App\Service\GenreService;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

class GenreServiceTest extends TestCase
{
    private GenreRepository $genreRepository;
    private GameRepository $gameRepository;
    private PaginatorInterface $paginator;
    private GenreService $genreService;

    protected function setUp(): void
    {
        $this->genreRepository = $this->createMock(GenreRepository::class);
        $this->gameRepository = $this->createMock(GameRepository::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);
        $this->genreService = new GenreService($this->genreRepository, $this->gameRepository, $this->paginator);
    }

    public function testGetPaginatedList(): void
    {
        // Create a mock for PaginationInterface
        $pagination = $this->createMock(PaginationInterface::class);

        // Define expected parameters and return value for paginator->paginate()
        $page = 1;
        $itemsPerPage = GenreRepository::PAGINATOR_ITEMS_PER_PAGE;
        $this->paginator->expects($this->once())
            ->method('paginate')
            ->with(
                $this->genreRepository->queryAll(),
                $page,
                $itemsPerPage
            )
            ->willReturn($pagination);

        // Call the getPaginatedList method and assert the returned value
        $result = $this->genreService->getPaginatedList($page);
        $this->assertSame($pagination, $result);
    }

    public function testSave()
    {
        // Mock a Genre entity
        $genre = $this->createMock(Genre::class);

        $this->genreRepository->expects($this->once())
            ->method('save')
            ->with($genre);

        $this->genreService->save($genre);
    }

    public function testDelete()
    {
        // Mock a Genre entity
        $genre = $this->createMock(Genre::class);

        $this->genreRepository->expects($this->once())
            ->method('delete')
            ->with($genre);

        $this->genreService->delete($genre);
    }

    public function testCanBeDeleted()
    {
        // Mock a Genre entity
        $genre = $this->createMock(Genre::class);

        // Mock the behavior of GameRepository
        $this->gameRepository->expects($this->once())
            ->method('countByGenre')
            ->with($genre)
            ->willReturn(0);

        $result = $this->genreService->canBeDeleted($genre);
        $this->assertTrue($result);
    }

    // Add more test cases as needed for other methods in GenreService
}
