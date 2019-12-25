<?php

namespace App\Admin;

use App\Entity\Journal;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItem;
use Sulu\Bundle\AdminBundle\Admin\Navigation\NavigationItemCollection;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;

class JournalAdmin extends Admin
{
    const JOURNAL_LIST_VIEW = 'app.journals_list';
    const JOURNAL_FORM_KEY = 'journal_details';
    const JOURNAL_ADD_FORM_VIEW = 'app.journal_add_form';
    const JOURNAL_EDIT_FORM_VIEW = 'app.journal_edit_form';

    /**
     * @var ViewBuilderFactoryInterface
     */
    private $viewBuilderFactory;

    public function __construct(ViewBuilderFactoryInterface $viewBuilderFactory)
    {
        $this->viewBuilderFactory = $viewBuilderFactory;
    }

    public function configureNavigationItems(NavigationItemCollection $navigationItemCollection): void
    {
        $journalNavigationItem = new NavigationItem('app.journals');
        $journalNavigationItem->setView(static::JOURNAL_LIST_VIEW);
        $journalNavigationItem->setIcon('su-calendar');
        $journalNavigationItem->setPosition(30);

        $navigationItemCollection->add($journalNavigationItem);
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        $listView = $this->viewBuilderFactory->createListViewBuilder(static::JOURNAL_LIST_VIEW, '/journals')
            ->setResourceKey(RESOURCE_KEY::class)
            ->setListKey('journals')
            ->addListAdapters(['table'])
            ->setAddView(static::JOURNAL_ADD_FORM_VIEW)
            ->setEditView(static::JOURNAL_EDIT_FORM_VIEW)
            ->addToolbarActions([new ToolbarAction('sulu_admin.add'), new ToolbarAction('sulu_admin.delete')]);

        $viewCollection->add($listView);

        $addFormView = $this->viewBuilderFactory->createResourceTabViewBuilder(static::JOURNAL_ADD_FORM_VIEW, '/journals/add')
            ->setResourceKey(RESOURCE_KEY::class)
            ->setBackView(static::JOURNAL_LIST_VIEW);

        $viewCollection->add($addFormView);

        $addDetailsFormView = $this->viewBuilderFactory->createFormViewBuilder(static::JOURNAL_ADD_FORM_VIEW . '.details', '/details')
            ->setResourceKey(RESOURCE_KEY::class)
            ->setFormKey(static::JOURNAL_FORM_KEY)
            ->setTabTitle('sulu_admin.details')
            ->setEditView(static::JOURNAL_EDIT_FORM_VIEW)
            ->addToolbarActions([new ToolbarAction('sulu_admin.save'), new ToolbarAction('sulu_admin.delete')])
            ->setParent(static::JOURNAL_ADD_FORM_VIEW);

        $viewCollection->add($addDetailsFormView);

        $editFormView = $this->viewBuilderFactory->createResourceTabViewBuilder(static::JOURNAL_EDIT_FORM_VIEW, '/journals/:id')
            ->setResourceKey(RESOURCE_KEY::class)
            ->setBackView(static::JOURNAL_LIST_VIEW);

        $viewCollection->add($editFormView);

        $editDetailsFormView = $this->viewBuilderFactory->createFormViewBuilder(static::JOURNAL_EDIT_FORM_VIEW . '.details', '/details')
            ->setResourceKey(RESOURCE_KEY::class)
            ->setFormKey(static::JOURNAL_FORM_KEY)
            ->setTabTitle('sulu_admin.details')
            ->addToolbarActions([new ToolbarAction('sulu_admin.save'), new ToolbarAction('sulu_admin.delete')])
            ->setParent(static::JOURNAL_EDIT_FORM_VIEW);

        $viewCollection->add($editDetailsFormView);
    }
}
