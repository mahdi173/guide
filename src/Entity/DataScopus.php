<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataScopus
 *
 * @ORM\Table(name="data_scopus")
 * @ORM\Entity(repositoryClass="App\Repository\DataScopusRepository")
 */
class DataScopus
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
     * @ORM\Column(name="Title", type="text", length=65535, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="CiteScore", type="string", length=40, nullable=false)
     */
    private $citescore;

    /**
     * @var string
     *
     * @ORM\Column(name="CitationCount", type="string", length=20, nullable=false)
     */
    private $citationcount;

    /**
     * @var string
     *
     * @ORM\Column(name="SJR", type="string", length=20, nullable=false)
     */
    private $sjr;

    /**
     * @var string
     *
     * @ORM\Column(name="RANK", type="string", length=20, nullable=false)
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="Publisher", type="text", length=65535, nullable=false)
     */
    private $publisher;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=40, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="OpenAccess", type="string", length=40, nullable=false)
     */
    private $openaccess;

    /**
     * @var string
     *
     * @ORM\Column(name="ScopusSubSubjectArea", type="string", length=200, nullable=false)
     */
    private $scopussubsubjectarea;

    /**
     * @var string
     *
     * @ORM\Column(name="Quartile", type="string", length=40, nullable=false)
     */
    private $quartile;

    /**
     * @var string
     *
     * @ORM\Column(name="ScopusSourceID", type="text", length=65535, nullable=false)
     */
    private $scopussourceid;

    /**
     * @var string
     *
     * @ORM\Column(name="PrintISSN", type="string", length=40, nullable=false)
     */
    private $printissn;

    /**
     * @var string
     *
     * @ORM\Column(name="EISSN", type="string", length=40, nullable=false)
     */
    private $eissn;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCitescore(): ?string
    {
        return $this->citescore;
    }

    public function setCitescore(string $citescore): self
    {
        $this->citescore = $citescore;

        return $this;
    }

    public function getCitationcount(): ?string
    {
        return $this->citationcount;
    }

    public function setCitationcount(string $citationcount): self
    {
        $this->citationcount = $citationcount;

        return $this;
    }

    public function getSjr(): ?string
    {
        return $this->sjr;
    }

    public function setSjr(string $sjr): self
    {
        $this->sjr = $sjr;

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

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getOpenaccess(): ?string
    {
        return $this->openaccess;
    }

    public function setOpenaccess(string $openaccess): self
    {
        $this->openaccess = $openaccess;

        return $this;
    }

    public function getScopussubsubjectarea(): ?string
    {
        return $this->scopussubsubjectarea;
    }

    public function setScopussubsubjectarea(string $scopussubsubjectarea): self
    {
        $this->scopussubsubjectarea = $scopussubsubjectarea;

        return $this;
    }

    public function getQuartile(): ?string
    {
        return $this->quartile;
    }

    public function setQuartile(string $quartile): self
    {
        $this->quartile = $quartile;

        return $this;
    }

    public function getScopussourceid(): ?string
    {
        return $this->scopussourceid;
    }

    public function setScopussourceid(string $scopussourceid): self
    {
        $this->scopussourceid = $scopussourceid;

        return $this;
    }

    public function getPrintissn(): ?string
    {
        return $this->printissn;
    }

    public function setPrintissn(string $printissn): self
    {
        $this->printissn = $printissn;

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
}
