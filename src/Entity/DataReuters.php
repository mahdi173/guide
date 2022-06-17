<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * DataReuters
 *
 * @ORM\Table(name="data_reuters")
 * @ORM\Entity(repositoryClass="App\Repository\DataReutersRepository")
 */
class DataReuters extends AbstractJournal
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="Rank", type="integer", nullable=false)
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="text", length=65535, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="TotalCites", type="string", length=20, nullable=false)
     */
    private $totalcites;

    /**
     * @var string
     *
     * @ORM\Column(name="JournalImpactFactor", type="string", length=20, nullable=false)
     */
    private $journalimpactfactor;

    /**
     * @var string
     *
     * @ORM\Column(name="EigenfactorScore", type="string", length=20, nullable=false)
     */
    private $eigenfactorscore;

    /**
     * @var string
     *
     * @ORM\Column(name="ISSN", type="text", length=65535, nullable=false)
     */
    private $issn;

    /**
     * @var string
     *
     * @ORM\Column(name="EISSN", type="text", length=65535, nullable=false)
     */
    private $eissn;

    /**
     * @var string
     *
     * @ORM\Column(name="Categoryname", type="text", length=65535, nullable=false)
     */
    private $categoryname;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $contributor;

    /**
     * @return User
     */
    public function getContributor(): ?User
    {
        return $this->contributor;
    }

    /**
     * @param User $contributor
     */
    public function setContributor(User $contributor): void
    {
        $this->contributor = $contributor;
    }

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favoriteReutersJournals")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTotalcites(): ?string
    {
        return $this->totalcites;
    }

    public function setTotalcites(string $totalcites): self
    {
        $this->totalcites = $totalcites;

        return $this;
    }

    public function getJournalimpactfactor(): ?string
    {
        return $this->journalimpactfactor;
    }

    public function setJournalimpactfactor(string $journalimpactfactor): self
    {
        $this->journalimpactfactor = $journalimpactfactor;

        return $this;
    }

    public function getEigenfactorscore(): ?string
    {
        return $this->eigenfactorscore;
    }

    public function setEigenfactorscore(string $eigenfactorscore): self
    {
        $this->eigenfactorscore = $eigenfactorscore;

        return $this;
    }

    public function getIssn(): ?string
    {
        return trim($this->issn);
    }

    public function setIssn(string $issn): self
    {
        $this->issn = $issn;

        return $this;
    }

    public function getEissn(): ?string
    {
        return trim($this->eissn);
    }

    public function setEissn(string $eissn): self
    {
        $this->eissn = $eissn;

        return $this;
    }

    public function getCategoryname(): ?string
    {
        return $this->categoryname;
    }

    public function setCategoryname(string $categoryname): self
    {
        $this->categoryname = $categoryname;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFavoriteReutersJournal($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeFavoriteReutersJournal($this);
        }

        return $this;
    }

    public function getUrl()
    {
        return "http://mjl.clarivate.com/cgi-bin/jrnlst/jlresults.cgi?PC=MASTER&ISSN=*" . $this->getIssn();
    }

    public function getPublisher()
    {
        return '';
    }

    public function getSubjectArea()
    {
        return $this->getCategoryname();
    }
}
