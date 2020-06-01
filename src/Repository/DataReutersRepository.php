<?php


namespace App\Repository;


use App\Entity\DataReuters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DataReutersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataReuters::class);
    }

    public function findInThomsonByIssn($value, $em)
    {

        $data_t_thomson = $this->findOneBy(array('eissn' => $value));
       if ($data_t_thomson == null) {
           $data_t_thomson = $this->findOneBy(array('issn' => $value));
       }
        return $data_t_thomson;
    }


    public function findInThomsonByTitle($value,$em)
    {
        $data_t_thomson = $this->findOneBy(array('title' => $value));
        if ($data_t_thomson == null) {
            $data_t_thomson = $this->findBy(array('title' => $value));
        }
        return $data_t_thomson;
    }
    public function selectTopListWeb($em)
    {
        return

            $this->createQueryBuilder('data_reuters')
                ->select("data_reuters")
                ->orderBy('data_reuters.rank', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
    }
}
