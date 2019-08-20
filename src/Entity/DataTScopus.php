<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DataTScopus
 *
 * @ORM\Table(name="data_t_scopus")
 * @ORM\Entity(repositoryClass="App\Repository\DataTScopusRepository")
 */
class DataTScopus
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
     * @var string|null
     *
     * @ORM\Column(name="ScopusSourceID", type="text", length=65535, nullable=true)
     */
    private $scopussourceid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Title", type="text", length=65535, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CiteScore", type="text", length=65535, nullable=true)
     */
    private $citescore;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CitationCount", type="text", length=65535, nullable=true)
     */
    private $citationcount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="SJR", type="text", length=65535, nullable=true)
     */
    private $sjr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="RANK", type="text", length=65535, nullable=true)
     */
    private $rank;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Publisher", type="text", length=65535, nullable=true)
     */
    private $publisher;

    /**
     * @var string|null
     *
     * @ORM\Column(name="OpenAccess", type="text", length=65535, nullable=true)
     */
    private $openaccess;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ScopusSubSubjectArea", type="text", length=65535, nullable=true)
     */
    private $scopussubsubjectarea;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Quartile", type="text", length=65535, nullable=true)
     */
    private $quartile;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PrintISSN", type="text", length=65535, nullable=true)
     */
    private $printissn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="EISSN", type="text", length=65535, nullable=true)
     */
    private $eissn;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScopussourceid(): ?string
    {
        return $this->scopussourceid;
    }

    public function setScopussourceid(?string $scopussourceid): self
    {
        $this->scopussourceid = $scopussourceid;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCitescore(): ?string
    {
        return $this->citescore;
    }

    public function setCitescore(?string $citescore): self
    {
        $this->citescore = $citescore;

        return $this;
    }

    public function getCitationcount(): ?string
    {
        return $this->citationcount;
    }

    public function setCitationcount(?string $citationcount): self
    {
        $this->citationcount = $citationcount;

        return $this;
    }

    public function getSjr(): ?string
    {
        return $this->sjr;
    }

    public function setSjr(?string $sjr): self
    {
        $this->sjr = $sjr;

        return $this;
    }

    public function getRank(): ?string
    {
        return $this->rank;
    }

    public function setRank(?string $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(?string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getOpenaccess(): ?string
    {
        return $this->openaccess;
    }

    public function setOpenaccess(?string $openaccess): self
    {
        $this->openaccess = $openaccess;

        return $this;
    }

    public function getScopussubsubjectarea(): ?string
    {
        return $this->scopussubsubjectarea;
    }

    public function setScopussubsubjectarea(?string $scopussubsubjectarea): self
    {
        $this->scopussubsubjectarea = $scopussubsubjectarea;

        return $this;
    }

    public function getQuartile(): ?string
    {
        return $this->quartile;
    }

    public function setQuartile(?string $quartile): self
    {
        $this->quartile = $quartile;

        return $this;
    }

    public function getPrintissn(): ?string
    {
        return trim($this->printissn);
    }

    public function setPrintissn(?string $printissn): self
    {
        $this->printissn = $printissn;

        return $this;
    }

    public function getEissn(): ?string
    {
        return trim($this->eissn);
    }

    public function setEissn(?string $eissn): self
    {
        $this->eissn = $eissn;

        return $this;
    }
}
