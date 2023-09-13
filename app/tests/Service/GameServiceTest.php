<?php

namespace App\Tests\Service;

use App\Entity\Game;
use App\Entity\Genre;
use App\Entity\Platform;
use App\Entity\Studio;
use App\Entity\Pic;
use App\Entity\User;
use App\Repository\GameRepository;
use App\Repository\GenreRepository;
use App\Repository\PlatformRepository;
use App\Repository\StudioRepository;
use App\Repository\PicRepository;
use App\Repository\UserRepository;
use App\Service\GameService;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    private GameRepository $gameRepository;
    private GenreRepository $genreRepository;
    private UserRepository $userRepository;

    private PaginatorInterface $paginator;
    private GameService $gameService;

    protected function setUp(): void
    {
        $this->gameRepository = $this->createMock(GameRepository::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);
        $this->gameService = new GameService($this->gameRepository, $this->paginator);
    }

    public function testGetPaginatedList(): void
    {
        // Create a mock for PaginationInterface
        $pagination = $this->createMock(PaginationInterface::class);

        // Define expected parameters and return value for paginator->paginate()
        $page = 1;
        $itemsPerPage = GameRepository::PAGINATOR_ITEMS_PER_PAGE;
        $this->paginator->expects($this->once())
            ->method('paginate')
            ->with(
                $this->gameRepository->queryAll(),
                $page,
                $itemsPerPage
            )
            ->willReturn($pagination);

        // Call the getPaginatedList method and assert the returned value
        $result = $this->gameService->getPaginatedList($page);
        $this->assertSame($pagination, $result);
    }

    public function testSave()
    {
        // Mock a Game entity
        $game = $this->createMock(Game::class);

        $this->gameRepository->expects($this->once())
            ->method('save')
            ->with($game);

        $this->gameService->save($game);
    }

    public function testDelete()
    {
        // Mock a Game entity
        $game = $this->createMock(Game::class);

        $this->gameRepository->expects($this->once())
            ->method('delete')
            ->with($game);

        $this->gameService->delete($game);
    }

    // Add more test cases as needed for other methods in GameService
}
