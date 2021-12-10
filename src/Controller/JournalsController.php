<?php

namespace App\Controller;

use App\Entity\Journal;
use App\Form\JournalType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**

 * @Route("/{_locale}/journals")
 */
class JournalsController extends BaseController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;




    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager=$manager;
    }
    /**
     * @Route("/add/{firstname}.{lastname}.{id}", name="add_journals", methods={"GET","POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function addJournals(Request $request): Response
    {
        $user=$this->getUser();

        $journal = new Journal();
        $form = $this->createNewJournalForm($journal);

        $firstName=$request->get('firstname');
        $lastName=$request->get('lastname');
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $journal->setUser($user);
                $this->manager->persist($journal);
                $this->manager->flush();
                return $this->redirectToRoute('book_index', ['firstname' => $firstName, 'lastname' => $lastName,'id'=>$user->getId()]);
            }
        return $this->render('journal/new.html.twig', [
            'book' => $journal,
            'form' => $form->createView(),
            'user' => $user,

        ]);

    }
    /**
     * @Route("/{firstname}.{lastname}.{id}", name="index_journals", methods={"GET"})
     * @Security("has_role('ROLE_USER')")
     */
    public function indexJournals(Request $request): Response
    {
        $user=$this->getUser();


        $firstName=$request->get('firstname');
        $lastName=$request->get('lastname');
        $journals=$this->manager->getRepository(Journal::class)->findBy(["user"=>$user]);
        return $this->render('journal/index.html.twig', [
            'journals' => $journals,
        ]);

    }
    /**
     * @return FormInterface
     */
    private function createNewJournalForm(Journal $journal){
        $form = $this->createForm(JournalType::class,$journal);
        $form->add('submit',SubmitType::class,["label"=>"Add journal"]);
        return  $form;

    }

}
