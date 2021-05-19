<?php


namespace App\Controller;


use App\DTO\ContactDT0;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PageController
 * @package App\Controller
 *
 * @Route("/{_locale}")
 */

class PageController extends AbstractController
{
    /** @var \Swift_Mailer */
    private $mailer;

    /**
     * PageController constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/aboutguidejournal", name="about_guidejournal")
     */

    public function about(){
        return $this->render('about/about.html.twig');
    }

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/contactguidejournal", name="contact_guidejournal")
     */
    public function contact(Request $request){
        $contact= new ContactDT0();
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $firstName=$form->get('firstName')->getData();
            $lastName=$form->get('lastName')->getData();
            $pays=$form->get('pays')->getData();
            $email=$form->get('email')->getData();
            $subject=$form->get('subject')->getData();
            $message=$form->get('message')->getData();
            $body = $this->renderView('mails/contact.html.twig',
                array('subject' => $subject,'firstName'=>$firstName,'lastName'=>$lastName,'pays'=>$pays,'message'=>$message));

            $msg = (new \Swift_Message())->setSubject("Contact")->setFrom($email)->setTo("contact@guidejournal.net")
                ->setBody($body);
            $this->mailer->send($msg);
            $this->addFlash("success", "Your message has been sent. Our team will contact you as soon as possible");
        }
        return $this->render('contact/contact.html.twig' ,["form" => $form->createView()]);
    }

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/indexing/services", name="services_page")
     */
    public function indexingServices(){
        return $this->render('addpages/indexservices.html.twig');
    }

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/guidejournal/privacy", name="privacy_page")
     */
    public function privacy(){
        return $this->render('addpages/privacy.html.twig');
    }

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/scopus/topjournallist", name="top_journal_page")
     */
    public function topJournal()
    {
        return $this->render('addpages/best.html.twig');

    }

    /**
     * Lists all data_t_scopus entities.
     *
     * @Route("/help-guidejournal", name="help_guidejournal")
     */
    public function help(Request $request){

        return $this->render('help.html.twig');
    }
}
