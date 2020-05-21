<?php

namespace App\Controller;


use App\Controller\BaseController;
use App\Entity\DataReuters;
use App\Entity\DataScopus;
use App\Entity\DataTScopus;
use App\Entity\User;
use App\Repository\DataReutersRepository;
use App\Repository\DataScopusRepository;
use App\Repository\DataTScopusRepository;
use App\Repository\UserRepository;
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
     * @Route("/{_locale}/favorite/switch", name="switch_favorite")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function switchFavoriteStatus(Request $request, EntityManagerInterface $manager, DataTScopusRepository $dscopusRepository, DataReutersRepository $dataReutersRepository)
    {
        $id = $request->get('id');
        $source = $request->get('source');

        /** @var User $me */
        $me = $this->getUser();

        if ('reuters' === $source)
        {
            /** @var DataReuters $journal */
            $journal = $dataReutersRepository->find($id);
            $favoriteList = $me->getFavoriteReutersJournals();

            if ($favoriteList->contains($journal)) {
                $me->removeFavoriteReutersJournal($journal);
            }else{
                $me->addFavoriteReutersJournal($journal);
            }
        }
        elseif ('scopus' === $source){

            /** @var DataTScopus $journal */
            $journal = $dscopusRepository->find($id);
            $favoriteList = $me->getFavoriteScopusJournals();

            if ($favoriteList->contains($journal)) {
//                $me->removeFavoriteScopusJournal($journal);
                throw $this->createNotFoundException();
            }else{
                $me->addFavoriteScopusJournal($journal);
            }
        }
        else {
            throw $this->createNotFoundException();
        }

        $manager->flush();
        $this->addFlash('success','journal was added with success');

        $issn =  $journal->getEissn() ?  $journal->getEissn() :  $journal->getIssn();
        return $this->redirectToRoute('data_t_scopus_results', ['eISSN' => $issn]);
    }

    /**
     * @Route("/{_locale}/Favorite/{firstname}.{lastname}", name="favorite_list",defaults={"lastname" = ""})
     */
    public function index(Request $request,UserRepository $userRepository){
        /** @var User $user */
        $user = $this->getUser();
        $firstName=$request->get('firstname');
        $lastName=$request->get('lastname');
        $myProfile=false;
        $em = $this->getDoctrine()->getManager();
        if($firstName && $lastName || ($firstName || $lastName )){
            $user=$userRepository->userFromConctact($firstName,$lastName);
            if($user){
                $user=$user[0];
            }
        }

        if($user==$this->getUser()){
            $myProfile=true;
        }

        $favorite=array_merge($user->getFavoriteScopusJournals()->toArray(), $user->getFavoriteReutersJournals()->toArray());

        return $this->render('favorite/index.html.twig',['favorite' => $favorite,'myProfile'=>$myProfile,'firstname'=>$firstName,'lastname'=>$lastName]);
    }

    /**
     * @Route("/{_locale}/Favorite/{firstname}.{lastname}/delete", name="delete_favorite")
     */
    public function remove(Request $request, UserRepository $userRepository,DataTScopusRepository $dscopusRepository, EntityManagerInterface $manager,DataReutersRepository $dataReutersRepository){

        $id=$request->get('id');
        $myProfile=false;
        /** @var User $user */
        $user = $this->getUser();
        $firstName=$request->get('firstname');
        $lastName=$request->get('lastname');

        if($firstName && $lastName || ($firstName || $lastName )){
            $user=$userRepository->userFromConctact($firstName,$lastName);
            if($user){
                $user=$user[0];
            }
        }

        if($user==$this->getUser()){
            $myProfile=true;
        }


        /** @var DataReuters $journal */

        $source = $request->get('source');
        if ('reuters' === $source)
        {

            $journal = $dataReutersRepository->find($id);
            $favoriteList = $user->getFavoriteReutersJournals();
            if ($favoriteList->contains($journal)) {
                $user->removeFavoriteScopusJournal($journal);
            }
        }elseif ('scopus' === $source){

            /** @var DataTScopus $journal */
            $journal = $dscopusRepository->find($id);
            $favoriteList = $user->getFavoriteScopusJournals();

            if ($favoriteList->contains($journal)) {
                $user->removeFavoriteScopusJournal($journal);
            }
        }
        else {
            throw $this->createNotFoundException();
        }

        $manager->flush();
        $this->addFlash('success','journal was deleted from your favorite with success');
        $favorite=array_merge($user->getFavoriteScopusJournals()->toArray(), $user->getFavoriteReutersJournals()->toArray());
//        return $this->render('favorite/index.html.twig',['favorite' => $favorite,"myProfile"=>$myProfile]);
        return $this->redirectToRoute('favorite_list',['firstname'=>$firstName,'lastname'=>$lastName]);
    }
}
