<?php

namespace JournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * data_reuters
 *
 * @ORM\Table(name="data_reuters")
 * @ORM\Entity(repositoryClass="JournalBundle\Repository\data_reutersRepository")
 */
class data_reuters
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
     * @var string
     *
     * @ORM\Column(name="Rank", type="string", length=255)
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
     * @param string $rank
     *
     * @return data_reuters
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return string
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
     * @return data_reuters
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
     * @return data_reuters
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
     * @return data_reuters
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
     * @return data_reuters
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
     * @return data_reuters
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
     * @return data_reuters
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
     * @return data_reuters
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

    public function findInThomsonByIssn($value, $em)
    {

        $data_t_thomson = $em->getRepository('JournalBundle:data_reuters')->findOneBy(array('eISSN' => $value));
        if ($data_t_thomson == null) {
            $data_t_thomson = $em->getRepository('JournalBundle:data_reuters')->findOneBy(array('iSSN' => $value));
        }
        return $data_t_thomson;
    }
    public function findInThomsonByTitle($value,$em){
        $data_t_thomson = $em->getRepository('JournalBundle:data_reuters')->findOneBy(array('title' => $value));
        if ($data_t_thomson == null) {
            $data_t_thomson = $em->getRepository('JournalBundle:data_reuters')->findBy(array('title' => $value));
        }
        return $data_t_thomson;
    }
}

