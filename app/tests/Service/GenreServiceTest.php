<?php
/**
 * Genre service tests.
 */

namespace Service;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use App\Repository\GameRepository;
use App\Service\GenreService;
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
        $pagination = $this->createMock(PaginationInterface::class);

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

        $result = $this->genreService->getPaginatedList($page);
        $this->assertSame($pagination, $result);
    }

    public function testSave()
    {
        $genre = $this->createMock(Genre::class);

        $this->genreRepository->expects($this->once())
            ->method('save')
            ->with($genre);

        $this->genreService->save($genre);
    }

    public function testDelete()
    {
        $genre = $this->createMock(Genre::class);

        $this->genreRepository->expects($this->once())
            ->method('delete')
            ->with($genre);

        $this->genreService->delete($genre);
    }

    public function canBeDeletedDataProvider(): array
    {
        return [
            [0, true, false],

            [1, false, false],

            [-1, false, true],
        ];
    }

    /**
     * @dataProvider canBeDeletedDataProvider
     */
    public function testCanBeDeleted(int $countByGenreResult, bool $expectedResult, bool $simulateException): void
    {
        $genre = $this->createMock(Genre::class);

        $this->gameRepository->expects($this->once())
            ->method('countByGenre')
            ->with($genre)
            ->willReturn($countByGenreResult);

        if ($simulateException) {
            $this->gameRepository->expects($this->once())
                ->method('countByGenre')
                ->willThrowException(new NoResultException());
        }

        try {
            $result = $this->genreService->canBeDeleted($genre);
            $this->assertSame($expectedResult, $result);
        } catch (NoResultException|NonUniqueResultException $exception) {
            $this->assertFalse($expectedResult);
        }
    }
}
