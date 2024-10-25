<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }


    public function findByUserBook($username)
    {
        return $this->createQueryBuilder('b')
        ->join('b.author', 'a')
        //->select('b')    
        ->addSelect('a')
            ->where("a.username LIKE :username ")
            ->setParameter('username', '%'.$username.'%')
            ->getQuery()
            ->getDQL()
        ;
    }

    public function findByUserBookDQL($username)
    {
        return $this->getEntityManager()
        ->createQuery("SELECT b, a FROM App\Entity\Book b INNER JOIN b.author a WHERE a.username LIKE :username")
        ->setParameter('username', '%'.$username.'%')
        ->getResult()

        ;
    }
    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
