<?php

namespace App\Command;

use App\Entity\DataReuters;
use App\Entity\DataScopus;
use App\Entity\DataThomsonMeta;
use App\Entity\DataTScopus;
use App\Entity\Journal;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Psr\Container\ContainerInterface;
use Sulu\Bundle\CommunityBundle\Manager\UserManager;
use Sulu\Bundle\ContactBundle\Entity\Contact;
use Sulu\Bundle\ContactBundle\Entity\ContactRepositoryInterface;
use Sulu\Component\Security\Authentication\UserRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LoadContributorsCommand extends Command
{
    protected static $defaultName = 'app:load-contributors';
    protected static $defaultDescription = 'Add a short description for your command';

    /** @var UserManager */
    private $userManager;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var ContactRepositoryInterface */
    private $contactRepository;

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

        $this->load();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }

    private function load()
    {
        $users = [];
        for ($i = 0; $i<250; $i++) {
            $faker = Factory::create();

            $user = $this->userRepository->createNew();
            $email = $faker->email();
            $user->setEmail($email);
            $user->setUsername($email);
            $user->setLocale('fr');
            $user->setSalt('------');

            $contact = $this->contactRepository->createNew();
            $contact->setFirstName($faker->firstName());
            $contact->setLastName($faker->lastName());
            $user->setPassword('----------');
            $user->setContact($contact);
            $this->userManager->createUser($user, 'guidejournal', 'GuidejournalUser');

            $this->entityManager->flush();
            $users[] = $user;
        }

        /** @var DataReuters[] $reuters */
        $journals = $this->entityManager->getRepository(DataReuters::class)->findAll();

        foreach ($journals as $journal) {
            if (empty($journal->getContributor())) {
                $contributor = $users[random_int(0, 250)];
                $journal->setContributor($contributor);
                $this->entityManager->flush();
            }
        }

        /** @var DataScopus[] $reuters */
        $journals = $this->entityManager->getRepository(DataScopus::class)->findAll();

        foreach ($journals as $journal) {
            if (empty($journal->getContributor())) {
                $contributor = $users[random_int(0, 250)];
                $journal->setContributor($contributor);
                $this->entityManager->flush();
            }
        }

        /** @var DataTScopus[] $reuters */
        $journals = $this->entityManager->getRepository(DataTScopus::class)->findAll();

        foreach ($journals as $journal) {
            if (empty($journal->getContributor())) {
                $_journal = new Journal();

                $contributor = $users[random_int(0, 250)];
                $journal->setContributor($contributor);
                $this->entityManager->flush();
            }
        }

        /** @var DataThomsonMeta[] $reuters */
        $journals = $this->entityManager->getRepository(DataThomsonMeta::class)->findAll();

        foreach ($journals as $journal) {
            if (empty($journal->getContributor())) {
                $contributor = $users[random_int(0, 250)];
                $journal->setContributor($contributor);
                $this->entityManager->flush();
            }
        }


    }
}
