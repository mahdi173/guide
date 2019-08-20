<?php


namespace App\Repository;


class DataReutersRepository extends BaseRepository
{

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
}