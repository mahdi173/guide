<?php

namespace App\Command;

use App\Entity\DataReuters;
use App\Entity\DataScopus;
use App\Entity\DataThomsonMeta;
use App\Entity\DataTScopus;
use App\Entity\Journal;
use App\Entity\User;
use App\Util\ISSN;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Psr\Container\ContainerInterface;
use Sulu\Bundle\CategoryBundle\Category\CategoryManagerInterface;
use Sulu\Bundle\CategoryBundle\Entity\Category;
use Sulu\Bundle\CategoryBundle\Entity\CategoryRepositoryInterface;
use Sulu\Bundle\CommunityBundle\Manager\UserManager;
use Sulu\Bundle\ContactBundle\Entity\AccountRepositoryInterface;
use Sulu\Bundle\ContactBundle\Entity\Contact;
use Sulu\Bundle\ContactBundle\Entity\ContactRepositoryInterface;
use Sulu\Component\Security\Authentication\UserRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportJournalsCommand extends Command
{
    protected static $defaultName = 'app:import-journals';
    protected static $defaultDescription = 'Add a short description for your command';

    /** @var UserManager */
    private $userManager;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var ContactRepositoryInterface */
    private $contactRepository;

    /** @var AccountRepositoryInterface */
    private $accountRepository;

    /** @var CategoryRepositoryInterface */
    private $categoryRepository;

    /** @var CategoryManagerInterface*/
    private $categoryManager;

    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * LoadContributorsCommand constructor.
     * @param UserRepositoryInterface $userRepository
     * @param ContactRepositoryInterface $contactRepository
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     */
    public function __construct(EntityManagerInterface $entityManager, ContainerInterface $container)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->container = $container;
        $this->userManager = $this->container->get('sulu_community.user_manager');
        $this->userRepository = $this->container->get('sulu.repository.user');
        $this->contactRepository = $this->container->get('sulu.repository.contact');
        $this->accountRepository = $this->container->get('sulu.repository.account');
        $this->categoryRepository = $this->container->get('sulu.repository.category');
        $this->categoryManager= $this->container->get('sulu_category.category_manager');
    }


    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);


        /** @var DataTScopus[] $journals */
        $scopus = $this->entityManager->getRepository(DataTScopus::class)->findAll();

        $this->loadCategories($scopus);
        $io->success('Categories loaded');
        $this->loadOrganisations($scopus);
        $io->success('Categories loaded');

        $this->load();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }

    /**
     * @param DataTScopus[] $journals
     * @throws \Sulu\Bundle\CategoryBundle\Exception\CategoryIdNotFoundException
     * @throws \Sulu\Bundle\CategoryBundle\Exception\CategoryKeyNotUniqueException
     * @throws \Sulu\Component\Rest\Exception\MissingArgumentException
     */
    private function loadCategories($journals)
    {

        foreach ($journals as $journal) {
            if ($journal->getSubjectArea()) {
                $category = $this->categoryRepository->findCategoryByKey($journal->getSubjectArea());
                if (!$category) {
                    $this->categoryManager->save([
                        'key' => $journal->getSubjectArea(),
                        'name' => $journal->getSubjectArea(),
                    ], null, 'en');
                }
            }
        }

        /** @var DataThomsonMeta[] $journals */
        $journals = $this->entityManager->getRepository(DataThomsonMeta::class)->findAll();

        foreach ($journals as $journal) {
            if ($journal->getCategoryname()) {
                $category = $this->categoryRepository->findCategoryByKey($journal->getCategoryname());
                if (!$category) {
                    $this->categoryManager->save([
                        'key' => $journal->getCategoryname(),
                        'name' => $journal->getCategoryname(),
                    ], null, 'en');
                }
            }
        }

    }

    /**
     * @param DataTScopus[] $journals
     * @throws \Sulu\Bundle\CategoryBundle\Exception\CategoryIdNotFoundException
     * @throws \Sulu\Bundle\CategoryBundle\Exception\CategoryKeyNotUniqueException
     * @throws \Sulu\Component\Rest\Exception\MissingArgumentException
     */
    private function loadOrganisations($journals)
    {
        $batchSize = 50;
        $i=0;

        $_publishers = $this->entityManager->getRepository(DataTScopus::class)->createQueryBuilder('data_tscopus')
            ->select('data_tscopus.publisher')
            ->distinct()
            ->getQuery()->getResult();

        $publishers = array_map(function ($item) {
            return $item['publisher'];
        }, $_publishers);

        foreach ($publishers as $publisher) {
            $account = $this->accountRepository->findOneBy(['name' => $publisher]);
            if (!$account) {
                $account = $this->accountRepository->createNew();
                $account->setName($publisher);
                $this->entityManager->persist($account);
            }

            if (($i % $batchSize) === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }

            $i=$i+1;
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

    }

    private function load()
    {
        $journals = $this->entityManager->getRepository(DataTScopus::class)
            ->createQueryBuilder('data_tscopus')
            ->select('data_tscopus.id, data_tscopus.sjr')
            ->where('data_tscopus.sjr IS NOT NULL')
            ->getQuery()->getResult()
        ;

        foreach ($journals as $journal) {
            if (!empty($journal['sjr'])) {
                $this->entityManager->getRepository(Journal::class)
                    ->updateSJR($journal);
                $this->entityManager->flush();
            }
        }

    }
}
