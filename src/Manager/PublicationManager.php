<?php


namespace App\Manager;


use App\Entity\User;
use App\Repository\AllPublicationRepository;
use Doctrine\ORM\EntityManagerInterface;


class PublicationManager
{
    /** @var AllPublicationRepository */
    private $allPublicationRepository;

    /** @var EntityManagerInterface */
    private $em;

    /**
     * FollowManager constructor.
     * @param AllPublicationRepository $allPublicationRepository
     * @param EntityManagerInterface $em;
     */
    public function __construct(AllPublicationRepository $allPublicationRepository,EntityManagerInterface $em)
    {
        $this->allPublicationRepository = $allPublicationRepository;
        $this->em = $em;
    }


    public function getAuthorsList($user)
    {
       $authors=[];
       $list=[];
       $pulications=$this->allPublicationRepository->findBy(['user'=>$user]);
       foreach ($pulications as $pulication){
          array_push($authors,explode(",",trim($pulication->getAuthors())));
       }

        foreach ($authors as $author){
           foreach ($author as $a) {
                if ($a!="" && $user->getFullName() && trim($a) != trim($user->getFullName())) {
                    array_push($list, trim($a));
                }
             }
        }

       return array_unique($list);
    }

    public function getAuthorsListForAuthor($author,$list1,$list2){
        $res1=[];
        $res2=[];

        foreach ($list1 as $aut)
        {
                if ($aut!="" && trim($aut) != trim($author)) {
                    array_push($res1, trim($aut));
                }
        }

        foreach ($list2 as $a)
        {
                if ($a!="" && trim($a) != trim($author)) {
                    array_push($res2, trim($a));
            }
        }
        return array_unique(array_merge(($res1),($res2)));
    }

    public function isAuthorStocked($author){

        $exist=false;
        $user=null;
       $users=$this->em->getRepository(User::class)->findAll();
        foreach ($users as $user)
        {
            if ($user->getFullName()==$author) {
               $exist=true;
               return $user;break;
            }
        }
        return $user;
    }

}