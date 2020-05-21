<?php

namespace App\Repository;


use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function userFromConctact($firstName,$lastName=null)
    {
        $qb = $this->createQueryBuilder('u');

        $qb->innerJoin("u.contact","c")
            ->where('c.firstName=:firstName')
            ->andWhere('c.mainEmail=u.email')
            ->setParameter('firstName', $firstName);
        if($lastName!=null && $lastName!=""){
            $qb->andWhere('c.lastName=:lastName')
                ->setParameter('lastName', $lastName);
         }

            return $qb ->getQuery()->getResult();
    }


}
