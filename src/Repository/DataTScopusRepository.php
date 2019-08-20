<?php


namespace App\Repository;

class DataTScopusRepository extends BaseRepository
{
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
                ->addSelect("data_tscopus")
                ->where("data_tscopus.title LIKE :value")
                ->setParameter('value', '%'.$value.'%')
                ->getQuery()
                ->getResult();
    }

}
