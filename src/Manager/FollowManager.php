<?php


namespace App\Manager;


use App\Repository\FollowRepository;

class FollowManager
{
    /** @var FollowRepository */
    private $followRepository;

    /**
     * FollowManager constructor.
     * @param FollowRepository $followRepository
     */
    public function __construct(FollowRepository $followRepository)
    {
        $this->followRepository = $followRepository;
    }


    public function followers($author)
    {
//        $count=0;
//        $a=$this->followRepository->findBy(['following'=>$author]);
//        if($a){
//            $a=$a[0];
//            $count=$a->getFollowers()->count();
//        }
//        dd($a->getFollowers()->getValues());
//       return $count;
//        return count($this->followRepository->findBy(['following'=>$author]));
//        return $count;
//        dd(count($this->followRepository->findAllFollowers($author)));
        return count($this->followRepository->findAllFollowers($author));
    }
}