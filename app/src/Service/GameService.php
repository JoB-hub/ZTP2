<?php
/**
 * Game service.
 */

namespace App\Service;

use App\Entity\Game;
use App\Repository\GameRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class GameService.
 */
class GameService implements GameServiceInterface
{
    /**
     * Game repository.
     */
    private GameRepository $gameRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param GameRepository     $gameRepository Game repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(GameRepository $gameRepository, PaginatorInterface $paginator)
    {
        $this->gameRepository = $gameRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->gameRepository->queryAll(),
            $page,
            GameRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Game $game Game entity
     */
    public function save(Game $game): void
    {
        $this->gameRepository->save($game);
    }

    /**
     * Delete entity.
     *
     * @param Game $game Game entity
     */
    public function delete(Game $game): void
    {
        $this->gameRepository->delete($game);
    }
}
