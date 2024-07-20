<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct($registry, Book::class);
    }

    public function save(Book $book): void
    {
        $this->entityManager->persist($book);

        $this->entityManager->flush();
    }

    public function delete(Book $book): void
    {
        $this->entityManager->remove($book);
        $this->entityManager->flush();
    }

    public function getPaginatedBookList(int $offset, int $limit): Paginator
    {
        $query = $this->createQueryBuilder('b')
            ->getQuery()
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new Paginator($query, true);
    }
}
