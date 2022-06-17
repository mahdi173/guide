<?php

namespace App\Controller\Admin;

use App\Entity\DataReuters;
use App\Entity\Journal;
use App\Repository\JournalRepository;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Psr\Container\ContainerInterface;
use Sulu\Bundle\ContactBundle\Entity\ContactRepositoryInterface;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\Metadata\FieldDescriptorFactoryInterface;
use Sulu\Component\Rest\ListBuilder\PaginatedRepresentation;
use Sulu\Component\Rest\RestController;
use Sulu\Component\Rest\RestHelperInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JournalController extends AbstractRestController implements ClassResourceInterface
{
    /**
     * @var ViewHandlerInterface
     */
    private $viewHandler;

    /**
     * @var FieldDescriptorFactoryInterface
     */
    private $fieldDescriptorFactory;

    /**
     * @var DoctrineListBuilderFactoryInterface
     */
    private $listBuilderFactory;

    /**
     * @var RestHelperInterface
     */
    private $restHelper;

    /** @var JournalRepository */
    private $repository;


    /** @var ContactRepositoryInterface */
    private $contactRepository;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        FieldDescriptorFactoryInterface $fieldDescriptorFactory,
        DoctrineListBuilderFactoryInterface $listBuilderFactory,
        RestHelperInterface $restHelper,
        JournalRepository $repository,
        ContainerInterface $container
    ) {
        $this->viewHandler = $viewHandler;
        $this->fieldDescriptorFactory = $fieldDescriptorFactory;
        $this->listBuilderFactory = $listBuilderFactory;
        $this->restHelper = $restHelper;
        $this->repository = $repository;
        $this->contactRepository = $container->get('sulu.repository.contact');

        parent::__construct($this->viewHandler);
    }

    public function cgetAction(): Response
    {
        $fieldDescriptors = $this->fieldDescriptorFactory->getFieldDescriptors(Journal::RESOURCE_KEY);
        $listBuilder = $this->listBuilderFactory->create(Journal::class);
        $this->restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);

        $listRepresentation = new PaginatedRepresentation(
            $listBuilder->execute(),
            Journal::RESOURCE_KEY,
            $listBuilder->getCurrentPage(),
            $listBuilder->getLimit(),
            $listBuilder->count()
        );

        return $this->viewHandler->handle(View::create($listRepresentation));
    }

    public function getAction(int $id, Request $request): Response
    {
        $entity = $this->load($id, $request);
        if (!$entity) {
            throw new NotFoundHttpException();
        }

        return $this->handleView($this->view($entity));
    }

    public function postAction(Request $request): Response
    {
        $entity = new Journal();
        $data = $request->request->all();

        $entity->setTitle($data['title']);
        $entity->setPublisher($data['publisher']);
        $entity->setEjr($data['ejr']);
        if ($data['contributor']) {
            $entity->setContributor($this->contactRepository->find($data['contributor']));
        }

        $this->repository->save($entity);

        return $this->handleView($this->view($entity));
    }

    public function putAction(int $id, Request $request): Response
    {
        $entity = $this->load($id, $request);

        if (empty($entity)) {
            throw new NotFoundHttpException();
        }

        $data = $request->request->all();

        $entity->setTitle($data['title']);
        $entity->setPublisher($data['publisher']);
        $entity->setEjr($data['ejr']);
        if ($data['contributor']) {
            $entity->setContributor($this->contactRepository->find($data['contributor']['id']));
        }

        $this->repository->save($entity);

        return $this->handleView($this->view($entity));
    }

    protected function load(int $id, Request $request): ?Journal
    {
        return $this->repository->findOneById($id);
    }
}
