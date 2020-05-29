<?php


namespace App\Manager;


use App\Repository\AllPublicationRepository;


class PublicationManager
{
    /** @var AllPublicationRepository */
    private $allPublicationRepository;

    /**
     * FollowManager constructor.
     * @param AllPublicationRepository $allPublicationRepository
     */
    public function __construct(AllPublicationRepository $allPublicationRepository)
    {
        $this->allPublicationRepository = $allPublicationRepository;
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
}