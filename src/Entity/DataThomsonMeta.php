<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataThomsonMeta
 *
 * @ORM\Table(name="data_thomson_meta")
 * @ORM\Entity(repositoryClass="App\Repository\DataThomsonMetaRepository")
 */
class DataThomsonMeta
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
     * @var string
     *
     * @ORM\Column(name="Fulltitle", type="text", length=65535, nullable=false)
     */
    private $fulltitle;

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
     * @var string
     *
     * @ORM\Column(name="Rank", type="string", length=40, nullable=false)
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="TotalCites", type="string", length=40, nullable=false)
     */
    private $totalcites;

    /**
     * @var string
     *
     * @ORM\Column(name="JournalImpactFactor", type="string", length=60, nullable=false)
     */
    private $journalimpactfactor;

    /**
     * @var string
     *
     * @ORM\Column(name="EigenfactorScore", type="string", length=60, nullable=false)
     */
    private $eigenfactorscore;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFulltitle(): ?string
    {
        return $this->fulltitle;
    }

    public function setFulltitle(string $fulltitle): self
    {
        $this->fulltitle = $fulltitle;

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

    public function getRank(): ?string
    {
        return $this->rank;
    }

    public function setRank(string $rank): self
    {
        $this->rank = $rank;

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
}
