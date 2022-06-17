<?php

namespace App\Entity;

use App\Util\ISSN;
use Doctrine\ORM\Mapping as ORM;
use Sulu\Bundle\ContactBundle\Entity\Account;
use Sulu\Bundle\ContactBundle\Entity\Contact;

/**
 * Class Journal
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\JournalRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Journal
{

    const RESOURCE_KEY = 'journals';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $categoryName;

    /**
     * @var \Sulu\Bundle\CategoryBundle\Entity\Category
     * @ORM\ManyToOne(targetEntity="Sulu\Bundle\CategoryBundle\Entity\Category")
     */
    protected $category;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $scopusSourceID;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $reutersSourceID;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ejr;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $sjr;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $publisher;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $quartile;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isOpenAccess;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $printISSN;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $originalPrintISSN;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $originalEISSN;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $eissn;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $rank;

    /**
      * @ORM\Column(type="string", nullable=true)
     */
   // protected $link;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
   // private $user;

    /**
     * @return mixed
     */
    /*public function getUser()
    {
        return $this->user;
    }*/

    /**
     * @param mixed $user
     */
   /* public function setUser($user): void
    {
        $this->user = $user;
    */
     
    /**
     *  @ORM\Column(type="float", nullable=true)
     */
    protected $impactFactor;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $eigenFactorScore;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $citeScore;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $citationCount;

    /**
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="Sulu\Bundle\ContactBundle\Entity\Contact")
     */
    protected $contributor;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="Sulu\Bundle\ContactBundle\Entity\Account")
     */
    protected $publisherOrg;

    /**
     * @var DataTScopus
     *
     * @ORM\ManyToOne(targetEntity="DataTScopus")
     */
    protected $scopusData;

    /**
     * @var DataThomsonMeta
     *
     * @ORM\ManyToOne(targetEntity="DataThomsonMeta")
     */
    protected $reutersThomsonData;

    /**
     * @return Contact
     */
    public function getContributor(): ?Contact
    {
        return $this->contributor;
    }

    /**
     * @param Contact $contributor
     */
    public function setContributor(Contact $contributor): void
    {
        $this->contributor = $contributor;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getEjr()
    {
        return $this->ejr;
    }

    /**
     * @param mixed $ejr
     */
    public function setEjr($ejr): void
    {
        $this->ejr = $ejr;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $rank
     */
    public function setRank($rank): void
    {
        $this->rank = $rank;
    }

    /**
     * @return mixed
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param mixed $publisher
     */
    public function setPublisher($publisher): void
    {
        $this->publisher = $publisher;
    }

    /**
     * @return mixed
     */
    public function getEissn()
    {
        return $this->eissn;
    }

    /**
     * @param mixed $eissn
     */
    public function setEissn($eissn): void
    {
        $this->eissn = $eissn;
    }

    /*
     *
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param $category
     * @return $this
     */
    public function setCategory($category): Journal
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    /**
     * @param string $categoryName
     * @return Journal
     */
    public function setCategoryName(string $categoryName): Journal
    {
        $this->categoryName = $categoryName;
        return $this;
    }

    /**
     * @return string
     */
    public function getScopusSourceID(): ?string
    {
        return $this->scopusSourceID;
    }

    /**
     * @param string $scopusSourceID
     * @return Journal
     */
    public function setScopusSourceID(?string $scopusSourceID): Journal
    {
        $this->scopusSourceID = $scopusSourceID;
        return $this;
    }

    /**
     * @return string
     */
    public function getReutersSourceID(): string
    {
        return $this->reutersSourceID;
    }

    /**
     * @param string $reutersSourceID
     * @return Journal
     */
    public function setReutersSourceID(string $reutersSourceID): Journal
    {
        $this->reutersSourceID = $reutersSourceID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuartile()
    {
        return $this->quartile;
    }

    /**
     * @param mixed $quartile
     * @return Journal
     */
    public function setQuartile($quartile)
    {
        $this->quartile = $quartile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsOpenAccess()
    {
        return $this->isOpenAccess;
    }

    /**
     * @param mixed $isOpenAccess
     * @return Journal
     */
    public function setIsOpenAccess($isOpenAccess)
    {
        $this->isOpenAccess = $isOpenAccess;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrintISSN()
    {
        return $this->printISSN;
    }

    /**
     * @param mixed $printISSN
     * @return Journal
     */
    public function setPrintISSN($printISSN)
    {
        $this->printISSN = $printISSN;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImpactFactor()
    {
        return $this->impactFactor;
    }

    /**
     * @param mixed $impactFactor
     * @return Journal
     */
    public function setImpactFactor($impactFactor)
    {
        if (is_string($impactFactor)) {
            $impactFactor = (float)str_replace(',', '.', $impactFactor);
        }

        $this->impactFactor = $impactFactor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEigenFactorScore()
    {
        return $this->eigenFactorScore;
    }

    /**
     * @param mixed $eigenFactorScore
     * @return Journal
     */
    public function setEigenFactorScore($eigenFactorScore)
    {
        if (is_string($eigenFactorScore)) {
            $eigenFactorScore = (float)str_replace(',', '.', $eigenFactorScore);
        }

        $this->eigenFactorScore = $eigenFactorScore;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCiteScore()
    {
        return $this->citeScore;
    }

    /**
     * @param mixed $citeScore
     * @return Journal
     */
    public function setCiteScore($citeScore)
    {
        if (is_string($citeScore)) {
            $citeScore = (float)str_replace(',', '.', $citeScore);
        }
        $this->citeScore = $citeScore;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCitationCount()
    {
        return $this->citationCount;
    }

    /**
     * @param mixed $citationCount
     * @return Journal
     */
    public function setCitationCount($citationCount)
    {
        if (is_string($citationCount)) {
            $citationCount = (int)str_replace(',', '', $citationCount);
        }
        $this->citationCount = $citationCount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOriginalPrintISSN()
    {
        return $this->originalPrintISSN;
    }

    /**
     * @param mixed $originalPrintISSN
     * @return Journal
     */
    public function setOriginalPrintISSN($originalPrintISSN)
    {
        $this->originalPrintISSN = $originalPrintISSN;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOriginalEISSN()
    {
        return $this->originalEISSN;
    }

    /**
     * @param mixed $originalEISSN
     * @return Journal
     */
    public function setOriginalEISSN($originalEISSN)
    {
        $this->originalEISSN = $originalEISSN;
        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function setISSNValue()
    {
        if (!empty(ISSN::format($this->originalPrintISSN))) {
            $this->setPrintISSN(ISSN::format($this->originalPrintISSN));
        }
        elseif (!empty(ISSN::format($this->originalEISSN))){
            $this->setPrintISSN(ISSN::format($this->originalEISSN));
        }
    }

    /**
     * @ORM\PrePersist()
     */
    public function setEISSNValue()
    {
        if (!empty(ISSN::format($this->originalEISSN))) {
            $this->setEissn(ISSN::format($this->originalEISSN));
        }
        elseif (!empty(ISSN::format($this->originalPrintISSN))) {
            $this->setEissn(ISSN::format($this->originalPrintISSN));
        }
    }

    /**
     * @return Account
     */
    public function getPublisherOrg(): ?Account
    {
        return $this->publisherOrg;
    }

    /**
     * @param ?Account $publisherOrg
     * @return Journal
     */
    public function setPublisherOrg(?Account $publisherOrg): Journal
    {
        $this->publisherOrg = $publisherOrg;
        return $this;
    }

    /**
     * @return DataTScopus
     */
    public function getScopusData(): DataTScopus
    {
        return $this->scopusData;
    }

    /**
     * @param DataTScopus $scopusData
     * @return Journal
     */
    public function setScopusData(DataTScopus $scopusData): Journal
    {
        $this->scopusData = $scopusData;
        return $this;
    }

    /**
     * @return DataThomsonMeta
     */
    public function getReutersThomsonData(): DataThomsonMeta
    {
        return $this->reutersThomsonData;
    }

    /**
     * @param DataThomsonMeta $reutersThomsonData
     * @return Journal
     */
    public function setReutersThomsonData(DataThomsonMeta $reutersThomsonData): Journal
    {
        $this->reutersThomsonData = $reutersThomsonData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSjr()
    {
        return $this->sjr;
    }

    /**
     * @param mixed $value
     * @return Journal
     */
    public function setSjr($value)
    {
        if (is_string($value)) {
            $value = (int)str_replace(',', '', $value);
        }

        $this->sjr = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link): void
    {
        $this->link = $link;
    }

}
