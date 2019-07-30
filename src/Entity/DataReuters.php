<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataReuters
 *
 * @ORM\Table(name="data_reuters")
 * @ORM\Entity(repositoryClass="App\Repository\DataReutersRepository")
 */
class DataReuters
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
        return $this->issn;
    }

    public function setIssn(string $issn): self
    {
        $this->issn = $issn;

        return $this;
    }

    public function getEissn(): ?string
    {
        return $this->eissn;
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
}
