<?php

namespace App\Controller;


use App\Controller\BaseController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FavoriteRepository;
use App\Entity\Publication;

class FavoriteController extends BaseController
{


    public function addFavorite(EntityManagerInterface $manager, FavoriteRepository $favoriteRepository, Publication $post)
    {
        $favorite = $favoriteRepository->findOneBy([
            'post' => $post,
            'user' => $this->getUser()
        ]);

        if (!$favorite) {
            $favorite = new Favorite();
            $favorite
                ->setPost($post)
                ->setUser($this->getUser());
            $manager->persist($favorite);
        } else {
            $manager->remove($favorite);
        }

        $manager->flush();

        return $this->render('favorite/index.html.twig');
    }
}
