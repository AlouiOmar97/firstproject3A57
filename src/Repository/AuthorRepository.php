<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

//    /**
//     * @return Author[] Returns an array of Author objects
//     */
    public function findByUser($value)
    {
        return $this->createQueryBuilder('au')
       // ->select('au.username')
       ->join('au.books','b')
            ->andWhere('au.username = ?1')
            ->andWhere(' au.email = ?2')
            ->setParameter('1', $value)
            ->setParameter('2', 'abc@gmail.com')
           // ->setParameters(new ArrayCollection(['val'=> $value, 'email' => 'abc@gmail.com']))
            ->orderBy('au.id', 'DESC')
          //  ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    public function findByUserBook($value)
    {
        return $this->createQueryBuilder('a')
            ->join('a.books','b')
            ->select('b')
            ->getQuery()
            ->getSQL()
        ;
    }

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
