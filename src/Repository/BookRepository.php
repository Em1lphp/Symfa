<?php

namespace App\Repository;

use App\Entity\Book;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return array
     */
    public function getBook(): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('b, a')
            ->from(Book::class, 'b')
            ->leftJoin('b.authors', 'a');
        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $surname
     * @return array
     */
    public function findByAuthorSurname(string $surname): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b')
            ->from(Book::class,'b')
            ->leftJoin('b.authors', 'a')
            ->andWhere('a.surname = :surname')
            ->setParameter('surname', $surname);
        return $qb->getQuery()->getResult();
    }
}
