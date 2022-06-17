<?php

namespace App\Service;

use App\Entity\DataTScopus;
use App\Repository\JournalRepository;
use Doctrine\ORM\EntityManagerInterface;

class ServiceForJournalFinder
{
    private $entityManager;

    /** @var JournalRepository */
    private $journalRepository;

    public function __construct(EntityManagerInterface $entityManager, JournalRepository $journalRepository)
    {
        $this->entityManager = $entityManager;
        $this->journalRepository = $journalRepository;
    }

    public function similarResult($val_title){
        $emS = $this->entityManager;
        $em = $this->entityManager->getRepository(DataTScopus::class);

        $array1 = explode(" ", $val_title);

        $new_value_eISSNS = "";

        for ($j = 0; $j < count($array1); $j++) {

            if (strcasecmp($array1[$j], "RESEARCH") != 0 && strcasecmp($array1[$j], "Journal") != 0 && strcasecmp($array1[$j], "in") != 0&& strcasecmp($array1[$j], "of") != 0 && strcasecmp($array1[$j], "in") != 0
                && strcasecmp($array1[$j], "and") != 0 && strcasecmp($array1[$j], "International") != 0) {
                $new_value_eISSNS = $new_value_eISSNS . "" . $array1[$j] . " ";
            }

        }
        // echo $new_value_eISSNS;
        $array = explode(" ", $new_value_eISSNS);
        $new_value = "";
        $var_compteur=2;
        if(count($array)==1)
            $var_compteur=1;
        for ($i = 0; $i < $var_compteur; $i++) {
            if ($array[$i] != null) {
                if ($i == 0) {
                    $new_value = $array[$i];
                } else $new_value = $new_value . " " . $array[$i];

            }


        }
        $pagination_slide = $em->findScopusSeveralResultByTitle($new_value, $emS);
        if(sizeof($pagination_slide)==1 && count($array)>2 ){
            $new_value = "";

            for ($i = 1; $i < $var_compteur+1; $i++) {
                if ($array[$i] != null) {
                    if ($i == 1) {
                        $new_value = $array[$i];
                    } else $new_value = $new_value . " " . $array[$i];

                }


            }
        }
        $pagination_slide = $em->findScopusSeveralResultByTitle($new_value, $emS);
        if ($pagination_slide ==  null) {
            $new_value = "";
            $numero_ditreaction=0;
            if(count($array)>2)$numero_ditreaction=count($array)-3;
            for ($i = (count($array) - 1); $i >= $numero_ditreaction; $i--) {
                if ($array[$i] != null) {
                    if ($i == (count($array) - 1)) {
                        $new_value = $array[$i];
                    } else $new_value = $new_value . " " . $array[$i];

                }
            }

            // echo $new_value;
            $pagination_slide = $em->findScopusSeveralResultByTitle($new_value, $emS);
            //echo sizeof($data_t_scopus);

        }


        return $pagination_slide;
    }

    public function search(string $term)
    {
    }
}
