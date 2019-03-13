<?php

namespace JournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThomsonData
 *
 * @ORM\Table(name="thomson_data")
 * @ORM\Entity(repositoryClass="JournalBundle\Repository\ThomsonDataRepository")
 */
class ThomsonData
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="Rank", type="integer")
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="TotalCites", type="string", length=255)
     */
    private $totalCites;

    /**
     * @var string
     *
     * @ORM\Column(name="JournalImpactFactor", type="string", length=255)
     */
    private $journalImpactFactor;

    /**
     * @var string
     *
     * @ORM\Column(name="EigenfactorScore", type="string", length=255)
     */
    private $eigenfactorScore;

    /**
     * @var string
     *
     * @ORM\Column(name="ISSN", type="string", length=255)
     */
    private $iSSN;

    /**
     * @var string
     *
     * @ORM\Column(name="EISSN", type="string", length=255)
     */
    private $eISSN;

    /**
     * @var string
     *
     * @ORM\Column(name="Categoryname", type="string", length=255)
     */
    private $categoryname;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     *
     * @return ThomsonData
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return ThomsonData
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set totalCites
     *
     * @param string $totalCites
     *
     * @return ThomsonData
     */
    public function setTotalCites($totalCites)
    {
        $this->totalCites = $totalCites;

        return $this;
    }

    /**
     * Get totalCites
     *
     * @return string
     */
    public function getTotalCites()
    {
        return $this->totalCites;
    }

    /**
     * Set journalImpactFactor
     *
     * @param string $journalImpactFactor
     *
     * @return ThomsonData
     */
    public function setJournalImpactFactor($journalImpactFactor)
    {
        $this->journalImpactFactor = $journalImpactFactor;

        return $this;
    }

    /**
     * Get journalImpactFactor
     *
     * @return string
     */
    public function getJournalImpactFactor()
    {
        return $this->journalImpactFactor;
    }

    /**
     * Set eigenfactorScore
     *
     * @param string $eigenfactorScore
     *
     * @return ThomsonData
     */
    public function setEigenfactorScore($eigenfactorScore)
    {
        $this->eigenfactorScore = $eigenfactorScore;

        return $this;
    }

    /**
     * Get eigenfactorScore
     *
     * @return string
     */
    public function getEigenfactorScore()
    {
        return $this->eigenfactorScore;
    }

    /**
     * Set iSSN
     *
     * @param string $iSSN
     *
     * @return ThomsonData
     */
    public function setISSN($iSSN)
    {
        $this->iSSN = $iSSN;

        return $this;
    }

    /**
     * Get iSSN
     *
     * @return string
     */
    public function getISSN()
    {
        return $this->iSSN;
    }

    /**
     * Set eISSN
     *
     * @param string $eISSN
     *
     * @return ThomsonData
     */
    public function setEISSN($eISSN)
    {
        $this->eISSN = $eISSN;

        return $this;
    }

    /**
     * Get eISSN
     *
     * @return string
     */
    public function getEISSN()
    {
        return $this->eISSN;
    }

    /**
     * Set categoryname
     *
     * @param string $categoryname
     *
     * @return ThomsonData
     */
    public function setCategoryname($categoryname)
    {
        $this->categoryname = $categoryname;

        return $this;
    }

    /**
     * Get categoryname
     *
     * @return string
     */
    public function getCategoryname()
    {
        return $this->categoryname;
    }
}

