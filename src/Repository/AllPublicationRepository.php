<?php


namespace App\Repository;


use App\Entity\Allpublications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;


class AllPublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Allpublications::class);
    }
    public function findPublicationByType($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.type = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }
}
