<?php

namespace App\Repository;

use App\Entity\Follow;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Follow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Follow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Follow[]    findAll()
 * @method Follow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Follow::class);
    }

    // /**
    //  * @return Follow[] Returns an array of Follow objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Follow
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }  */
    public function findAllFollowers($author)
    {

        return $this->createQueryBuilder('f')
            ->select('u.username,u.fullName')

            ->innerJoin("f.followers","u")
            ->where('f.following=:author')
            ->setParameter('author', $author)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllFollowing($author)
    {

        return $this->createQueryBuilder('f')
            ->select('f')
            ->innerJoin("f.followers","u")
            ->where('u=:author')
            ->setParameter('author', $author)
            ->getQuery()
            ->getResult()
            ;
    }

}
