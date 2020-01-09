<?php

namespace App\Controller;


use App\Controller\BaseController;
use App\Entity\DataReuters;
use App\Entity\DataScopus;
use App\Entity\DataTScopus;
use App\Entity\User;
use App\Repository\DataScopusRepository;
use App\Repository\DataTScopusRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FavoriteRepository;
use App\Entity\Publication;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

class FavoriteController extends BaseController
{

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var DataTScopusRepository
     */
    private $dscopusRepository;


    public function __construct(EntityManagerInterface $manager, DataTScopusRepository $dscopusRepository)
    {
        $this->manager=$manager;
        $this->dscopusRepository=$dscopusRepository;
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param DataTScopusRepository $dscopusRepository
     *
     * @Route("/Favorite/add", name="add_to_favorite")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function switchFavoriteStatus(Request $request, EntityManagerInterface $manager, DataTScopusRepository $dscopusRepository)
    {
        $id=$request->get('id');
        $journal = $dscopusRepository->find($id);

        /** @var User $me */
        $me = $this->getUser();

        $favoriteList = $me->getFavoriteScopusJournals();

//        if ($favoriteList->contains($journal)) {
//            $favoriteList->remove($journal);
//        }else{
            $favoriteList->add($journal);
//        }

        $manager->flush();

            $this->addFlash('success','journal was added with success');

        return new Response('journal was added with success');

    }

    /**
     * @Rest\Route("/Favorite", name="favorite_list")
     */
    public function index(){
        /** @var User $me */
        $me = $this->getUser();
        $favorite=$me->getFavoriteScopusJournals();

        return $this->render('favorite/index.html.twig',['favorite' => $favorite]);
    }
}
