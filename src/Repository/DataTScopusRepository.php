<?php


namespace App\Repository;

use App\Entity\DataTScopus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DataTScopusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataTScopus::class);
    }

    public function findInScopusByIssn($value, $em)
    {
        $data_t_scopus = $this->findOneBy(array('eissn' => $value));
        if ($data_t_scopus == null) {
            $data_t_scopus = $this->findOneBy(array('printissn' => $value));
        }

        return $data_t_scopus;
    }
    public function findInScopusByTitle($value, $em)
    {

        return $this->findOneBy(array('title' => $value));
    }

    public function findScopusSeveralResultByTitle($value, $em)
    {
        return

            $this->createQueryBuilder('data_tscopus')
                ->select("data_tscopus")
                ->where("data_tscopus.title LIKE :value")
                ->setParameter('value', '%'.$value.'%')
                ->getQuery()
                ->getResult();
    }
    public function selectTopListScopus($em)
    {
        return

            $this->createQueryBuilder('data_tscopus')
                ->select("data_tscopus")
                ->orderBy('data_tscopus.sjr', 'DESC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
    }

}
