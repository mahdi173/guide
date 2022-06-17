<?php


namespace App\Repository;


use App\Entity\Journal;
use App\Util\ISSN;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Utility\IdentifierFlattener;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

class JournalRepository extends ServiceEntityRepository
{
    /** @var PaginatorInterface */
    protected $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Journal::class);
        $this->paginator = $paginator;
    }

    public function save(Journal $journal)
    {
        $this->getEntityManager()
            ->persist($journal);
        $this->getEntityManager()->flush();
    }

    public function search(string $term, array $options = [], $page = 1)
    {
        $qb = $this->createQueryBuilder('journal')
            ->select('journal');

        if (strlen($term) <3) {
            return
                $this->createQueryBuilder('journal')
                ->select('journal')
                ->where('journal.id <0 ') // Return empty results
                ;
        }
        if (ISSN::isISSN($term)) {
            return
                $qb
                ->where('journal.printISSN = :term')
                ->orWhere('journal.eissn = :term')
                ->setParameter('term', $term)
                ->orderBy('journal.rank', 'DESC')
            ;
        }

        if ($term) {
            $qb
                ->where('journal.title LIKE :term')
                ->setParameter('term', '%'.$term.'%')
                ->orderBy('journal.rank', 'ASC')
            ;
        }

        return $qb;
    }

    public function updateSJR($data)
    {
        $this
            ->createQueryBuilder('journal')
            ->update(Journal::class, 'journal')
            ->set('journal.sjr', ':sjr')
            ->where('journal.scopusData = :id')
            ->setParameter('sjr', str_replace(',', '.', $data['sjr']))
            ->setParameter('id', $data['id'])
            ->getQuery()->execute()
        ;
    }
}
