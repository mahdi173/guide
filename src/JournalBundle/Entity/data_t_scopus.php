<?php

namespace JournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * data_t_scopus
 *
 * @ORM\Table(name="data_t_scopus")
 * @ORM\Entity(repositoryClass="JournalBundle\Repository\data_t_scopusRepository")
 */
class data_t_scopus
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
     * @ORM\Column(name="ScopusSourceID", type="string", length=255)
     */
    private $scopusSourceID;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="CiteScore", type="string", length=255)
     */
    private $citeScore;

    /**
     * @var string
     *
     * @ORM\Column(name="CitationCount", type="string", length=255)
     */
    private $citationCount;

    /**
     * @var string
     *
     * @ORM\Column(name="SJR", type="string", length=255)
     */
    private $sJR;

    /**
     * @var string
     *
     * @ORM\Column(name="RANK", type="string", length=255)
     */
    private $rANK;

    /**
     * @var string
     *
     * @ORM\Column(name="Publisher", type="string", length=255)
     */
    private $publisher;

    /**
     * @var string
     *
     * @ORM\Column(name="OpenAccess", type="string", length=255)
     */
    private $openAccess;

    /**
     * @var string
     *
     * @ORM\Column(name="ScopusSubSubjectArea", type="string", length=255)
     */
    private $scopusSubSubjectArea;

    /**
     * @var string
     *
     * @ORM\Column(name="Quartile", type="string", length=255)
     */
    private $quartile;

    /**
     * @var string
     *
     * @ORM\Column(name="PrintISSN", type="string", length=255)
     */
    private $printISSN;

    /**
     * @var string
     *
     * @ORM\Column(name="EISSN", type="string", length=255)
     */
    private $eISSN;


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
     * Set scopusSourceID
     *
     * @param string $scopusSourceID
     *
     * @return data_t_scopus
     */
    public function setScopusSourceID($scopusSourceID)
    {
        $this->scopusSourceID = $scopusSourceID;

        return $this;
    }

    /**
     * Get scopusSourceID
     *
     * @return string
     */
    public function getScopusSourceID()
    {
        return $this->scopusSourceID;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return data_t_scopus
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
     * Set citeScore
     *
     * @param string $citeScore
     *
     * @return data_t_scopus
     */
    public function setCiteScore($citeScore)
    {
        $this->citeScore = $citeScore;

        return $this;
    }

    /**
     * Get citeScore
     *
     * @return string
     */
    public function getCiteScore()
    {
        return $this->citeScore;
    }

    /**
     * Set citationCount
     *
     * @param string $citationCount
     *
     * @return data_t_scopus
     */
    public function setCitationCount($citationCount)
    {
        $this->citationCount = $citationCount;

        return $this;
    }

    /**
     * Get citationCount
     *
     * @return string
     */
    public function getCitationCount()
    {
        return $this->citationCount;
    }

    /**
     * Set sJR
     *
     * @param string $sJR
     *
     * @return data_t_scopus
     */
    public function setSJR($sJR)
    {
        $this->sJR = $sJR;

        return $this;
    }

    /**
     * Get sJR
     *
     * @return string
     */
    public function getSJR()
    {
        return $this->sJR;
    }

    /**
     * Set rANK
     *
     * @param string $rANK
     *
     * @return data_t_scopus
     */
    public function setRANK($rANK)
    {
        $this->rANK = $rANK;

        return $this;
    }

    /**
     * Get rANK
     *
     * @return string
     */
    public function getRANK()
    {
        return $this->rANK;
    }

    /**
     * Set publisher
     *
     * @param string $publisher
     *
     * @return data_t_scopus
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set openAccess
     *
     * @param string $openAccess
     *
     * @return data_t_scopus
     */
    public function setOpenAccess($openAccess)
    {
        $this->openAccess = $openAccess;

        return $this;
    }

    /**
     * Get openAccess
     *
     * @return string
     */
    public function getOpenAccess()
    {
        return $this->openAccess;
    }

    /**
     * Set scopusSubSubjectArea
     *
     * @param string $scopusSubSubjectArea
     *
     * @return data_t_scopus
     */
    public function setScopusSubSubjectArea($scopusSubSubjectArea)
    {
        $this->scopusSubSubjectArea = $scopusSubSubjectArea;

        return $this;
    }

    /**
     * Get scopusSubSubjectArea
     *
     * @return string
     */
    public function getScopusSubSubjectArea()
    {
        return $this->scopusSubSubjectArea;
    }

    /**
     * Set quartile
     *
     * @param string $quartile
     *
     * @return data_t_scopus
     */
    public function setQuartile($quartile)
    {
        $this->quartile = $quartile;

        return $this;
    }

    /**
     * Get quartile
     *
     * @return string
     */
    public function getQuartile()
    {
        return $this->quartile;
    }

    /**
     * Set printISSN
     *
     * @param string $printISSN
     *
     * @return data_t_scopus
     */
    public function setPrintISSN($printISSN)
    {
        $this->printISSN = $printISSN;

        return $this;
    }

    /**
     * Get printISSN
     *
     * @return string
     */
    public function getPrintISSN()
    {
        return $this->printISSN;
    }

    /**
     * Set eISSN
     *
     * @param string $eISSN
     *
     * @return data_t_scopus
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
    public function findInScopusByIssn($value, $em)
    {

        $data_t_scopus = $em->getRepository('JournalBundle:data_t_scopus')->findOneBy(array('eISSN' => $value));
        if ($data_t_scopus == null) {
            $data_t_scopus = $em->getRepository('JournalBundle:data_t_scopus')->findOneBy(array('printISSN' => $value));

        }
        return $data_t_scopus;
    }
    public function findInScopusByTitle($value, $em){

        $data_t_scopus = $em->getRepository('JournalBundle:data_t_scopus')->findOneBy(array('title' => $value));
        return $data_t_scopus;
    }
    public function findScopusSeveralResultByTitle($value, $em){
        $sqlQuery = $em->createQuery("select s from JournalBundle:data_t_scopus s where s.title like :value")
            ->setParameter('value', '%'.$value.'%');
        $data_t_scopus=$sqlQuery->getResult();
        return $data_t_scopus;
    }
}

