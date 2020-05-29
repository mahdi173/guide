<?php


namespace App\Repository;


use App\Entity\Allpublications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;

/**
 * @method Allpublications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Allpublications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Allpublications[]    findAll()
 * @method Allpublications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AllPublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Allpublications::class);
    }
    public function findPublicationByType($value,$user)
    {
        return $this->createQueryBuilder('p')
            ->where('p.type = :val')
            ->andWhere('p.user=:user')
            ->setParameter('val', $value)
            ->setParameter('user', $user)
            ->orderBy('p.year','desc')
            ->getQuery()
            ->getResult()
            ;
    }

    public function allPublications($user)
    {
        return $this->createQueryBuilder('p')
            ->where('p.user=:user')
            ->setParameter('user', $user)
            ->orderBy('p.year','desc')
            ->getQuery()
            ->getResult()
            ;
    }
}
