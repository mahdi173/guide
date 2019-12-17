<?php


namespace App\Controller\Website;

use App\Initializer\Initializer;
use Sulu\Component\DocumentManager\DocumentManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ExampleController
 * @package App\Controller\Website
 *
 * @Route("/example")
 */
class ExampleController extends AbstractController
{
    /** @var Initializer */
    private $initializer;

    /**
     * ExampleController constructor.
     * @param Initializer $initializer
     */
    public function __construct(Initializer $initializer)
    {
        $this->initializer = $initializer;
    }


    /**
     * @param Request $request
     * @param Initializer $initializer
     *
     * @Route("/index")
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('key', TextType::class)
            ->getForm()
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $key = strtolower($form->get('key')->getData());

            if ($key) {
                $this->initializer->initialize($key, $this->renderView('skeletons/webspace.xml.twig', ['key'=> $key]));
            }
        }
        return $this->render('example/index.html.twig', [
            'form'=> $form->createView()
        ]);
    }
}