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
    public function selectALLCategories($em)
    {
        return

            $this->createQueryBuilder('data_tscopus')
                ->select("data_tscopus.scopussubsubjectarea")
                ->distinct()
                ->orderBy('data_tscopus.scopussubsubjectarea', 'ASC')
                ->getQuery()
                ->getResult();
    }
    public function selectALLPublishers($em)
    {
        return

            $this->createQueryBuilder('data_tscopus')
                ->select("data_tscopus.publisher")
                ->distinct()
                ->orderBy('data_tscopus.publisher', 'ASC')
                ->getQuery()
                ->getResult();
    }
    public function selectForAdvancesearch($em,$publisher, $subject_area, $tab_qrtle, $ta_openaccs, $sjr_value, $operation)
    {
        if($operation=="op2"){

            return

                $this->createQueryBuilder('data_tscopus')
                    ->select("data_tscopus")
                    ->where("data_tscopus.publisher = :value")
                    ->setParameter('value', $publisher)
                    ->andWhere("data_tscopus.scopussubsubjectarea = :value1")
                    ->setParameter('value1', $subject_area)
                    ->andWhere("data_tscopus.quartile IN (:value2)")
                    ->setParameter('value2', $tab_qrtle)
                    ->andWhere("data_tscopus.openaccess IN (:value4)")
                    ->setParameter('value4', $ta_openaccs)
                    ->andWhere("data_tscopus.sjr <= :value3")
                    ->setParameter('value3', $sjr_value)
                    ->getQuery()
                    ->getResult();
        }
        else {

        return

            $this->createQueryBuilder('data_tscopus')
                ->select("data_tscopus")
                ->where("data_tscopus.publisher = :value")
                ->setParameter('value', $publisher)
                ->andWhere("data_tscopus.scopussubsubjectarea = :value1")
                ->setParameter('value1', $subject_area)
                ->andWhere("data_tscopus.quartile IN (:value2)")
                ->setParameter('value2', $tab_qrtle)
                ->andWhere("data_tscopus.openaccess IN (:value4)")
                ->setParameter('value4', $ta_openaccs)
                ->andWhere("data_tscopus.sjr >= :value3")
                ->setParameter('value3', $sjr_value)
                ->getQuery()
                ->getResult();
        }
    }
    public function selectForAdvancesearchSJRInf($em,$publisher, $subject_area, $tab_qrtle, $ta_openaccs, $sjr_value)
    {
        return

            $this->createQueryBuilder('data_tscopus')
                ->select("data_tscopus")
                ->where("data_tscopus.publisher = :value")
                ->setParameter('value', $publisher)
                ->andWhere("data_tscopus.scopussubsubjectarea = :value1")
                ->setParameter('value1', $subject_area)
                ->andWhere("data_tscopus.quartile IN (:value2)")
                ->setParameter('value2', $tab_qrtle)
                ->andWhere("data_tscopus.openaccess IN (:value4)")
                ->setParameter('value4', $ta_openaccs)
                ->andWhere("data_tscopus.sjr <= :value3")
                ->setParameter('value3', $sjr_value)
                ->getQuery()
                ->getResult();
    }
    public function selectForAdvancesearchWithoutSubjectAndPublisher($em, $tab_qrtle, $ta_openaccs, $sjr_value, $operation)
    {
        if($operation=="op2"){
            return
            $this->createQueryBuilder('data_tscopus')
                ->select("data_tscopus")
                ->Where("data_tscopus.quartile IN (:value2)")
                ->setParameter('value2', $tab_qrtle)
                ->andWhere("data_tscopus.openaccess IN (:value4)")
                ->setParameter('value4', $ta_openaccs)
                ->andWhere("data_tscopus.sjr <= :value3")
                ->setParameter('value3', $sjr_value)
                ->getQuery()
                ->getResult();
        }
        else {
        return

            $this->createQueryBuilder('data_tscopus')
                ->select("data_tscopus")
                ->Where("data_tscopus.quartile IN (:value2)")
                ->setParameter('value2', $tab_qrtle)
                ->andWhere("data_tscopus.openaccess IN (:value4)")
                ->setParameter('value4', $ta_openaccs)
                ->andWhere("data_tscopus.sjr >= :value3")
                ->setParameter('value3', $sjr_value)
                ->getQuery()
                ->getResult();
        }
    }
    public function selectForAdvancesearchWithoutSubjectarea($em,$publisher, $tab_qrtle, $ta_openaccs, $sjr_value, $operation)
    {
        if($operation=="op2"){
            return
            $this->createQueryBuilder('data_tscopus')
                ->select("data_tscopus")
                ->where("data_tscopus.publisher = :value")
                ->setParameter('value', $publisher)
                ->andWhere("data_tscopus.quartile IN (:value2)")
                ->setParameter('value2', $tab_qrtle)
                ->andWhere("data_tscopus.openaccess IN (:value4)")
                ->setParameter('value4', $ta_openaccs)
                ->andWhere("data_tscopus.sjr <= :value3")
                ->setParameter('value3', $sjr_value)
                ->getQuery()
                ->getResult();
        }
else
        return

            $this->createQueryBuilder('data_tscopus')
                ->select("data_tscopus")
                ->where("data_tscopus.publisher = :value")
                ->setParameter('value', $publisher)
                ->andWhere("data_tscopus.quartile IN (:value2)")
                ->setParameter('value2', $tab_qrtle)
                ->andWhere("data_tscopus.openaccess IN (:value4)")
                ->setParameter('value4', $ta_openaccs)
                ->andWhere("data_tscopus.sjr >= :value3")
                ->setParameter('value3', $sjr_value)
                ->getQuery()
                ->getResult();
    }
    public function selectForAdvancesearchWithoutPublisher($em,$subject_area, $tab_qrtle, $ta_openaccs, $sjr_value, $operation)
    {
if($operation=="op2"){
    return
    $this->createQueryBuilder('data_tscopus')
        ->select("data_tscopus")
        ->Where("data_tscopus.quartile IN (:value2)")
        ->setParameter('value2', $tab_qrtle)
        ->andWhere("data_tscopus.scopussubsubjectarea = :value1")
        ->setParameter('value1', $subject_area)
        ->andWhere("data_tscopus.openaccess IN (:value4)")
        ->setParameter('value4', $ta_openaccs)
        ->andWhere("data_tscopus.sjr <= :value3")
        ->setParameter('value3', $sjr_value)
        ->getQuery()
        ->getResult();
}
        return

            $this->createQueryBuilder('data_tscopus')
                ->select("data_tscopus")
                ->Where("data_tscopus.quartile IN (:value2)")
                ->setParameter('value2', $tab_qrtle)
                ->andWhere("data_tscopus.scopussubsubjectarea = :value1")
                ->setParameter('value1', $subject_area)
                ->andWhere("data_tscopus.openaccess IN (:value4)")
                ->setParameter('value4', $ta_openaccs)
                ->andWhere("data_tscopus.sjr >= :value3")
                ->setParameter('value3', $sjr_value)
                ->getQuery()
                ->getResult();
    }
}
