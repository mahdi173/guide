<?php

namespace App\Repository;

use App\Entity\Favorite;
use Doctrine\Persistence\ManagerRegistry;

/**
 *
 */
class FavoriteRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Favorite::class);
    }
}
