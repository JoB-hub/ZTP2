<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Game;
use App\Entity\Genre;
use App\Entity\Studio;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class GameRepository.
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @extends ServiceEntityRepository<Game>
 */
class GameRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in configuration files.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select(
                'partial game.{id, title, description, createdAt}',
                'partial genre.{id, name}'
            )
            ->join('game.genre', 'genre')
            ->orderBy('game.id', 'DESC');
    }

    /**
     * Count games by genre.
     *
     * @param Genre $genre Genre
     *
     * @return int Number of games in genre
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByGenre(Genre $genre): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('game.id'))
            ->where('game.genre = :genre')
            ->setParameter(':genre', $genre)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Count games by comment.
     *
     * @param Comment $comment Comment
     *
     * @return int Number of games in comment
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByComment(Comment $comment): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('game.id'))
            ->where('game.comment = :comment')
            ->setParameter(':comment', $comment)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Count games by studio.
     *
     * @param Studio $studio Genre
     *
     * @return int Number of games in studio
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByStudio(Studio $studio): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('game.id'))
            ->where('game.studio = :studio')
            ->setParameter(':studio', $studio)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Save entity.
     *
     * @param Game $game Game entity
     */
    public function save(Game $game): void
    {
        $this->_em->persist($game);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Game $game Game entity
     */
    public function delete(Game $game): void
    {
        $this->_em->remove($game);
        $this->_em->flush();
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('game');
    }

    /**
     * Query games by author.
     *
     * @param User $user User entity
     *
     * @return QueryBuilder Query builder
     */
    public function queryByAuthor(User $user): QueryBuilder
    {
        $queryBuilder = $this->queryAll();

        $queryBuilder->andWhere('game.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }
}
