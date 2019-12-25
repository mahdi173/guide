<?php

namespace App\Controller\Admin;

use App\Entity\Journal;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\Metadata\FieldDescriptorFactoryInterface;
use Sulu\Component\Rest\ListBuilder\PaginatedRepresentation;
use Sulu\Component\Rest\RestHelperInterface;
use Symfony\Component\HttpFoundation\Response;

class JournalController implements ClassResourceInterface
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

    public function __construct(
        ViewHandlerInterface $viewHandler,
        FieldDescriptorFactoryInterface $fieldDescriptorFactory,
        DoctrineListBuilderFactoryInterface $listBuilderFactory,
        RestHelperInterface $restHelper
    ) {
        $this->viewHandler = $viewHandler;
        $this->fieldDescriptorFactory = $fieldDescriptorFactory;
        $this->listBuilderFactory = $listBuilderFactory;
        $this->restHelper = $restHelper;
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
}
