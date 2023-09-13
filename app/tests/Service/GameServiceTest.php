<?php
/**
 * Game service tests.
 */

namespace Service;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Service\GameService;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    private GameRepository $gameRepository;
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
        $pagination = $this->createMock(PaginationInterface::class);

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

        $result = $this->gameService->getPaginatedList($page);
        $this->assertSame($pagination, $result);
    }

    public function testSave()
    {
        $game = $this->createMock(Game::class);

        $this->gameRepository->expects($this->once())
            ->method('save')
            ->with($game);

        $this->gameService->save($game);
    }

    public function testDelete()
    {
        $game = $this->createMock(Game::class);

        $this->gameRepository->expects($this->once())
            ->method('delete')
            ->with($game);

        $this->gameService->delete($game);
    }
}
