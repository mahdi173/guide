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


        return $this->followRepository->findAllFollowers($author);
    }
}