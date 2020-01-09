<?php


namespace App\Repository;


use App\Entity\DataScopus;
use App\Entity\DataTScopus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DataScopusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataScopus::class);
    }

}
