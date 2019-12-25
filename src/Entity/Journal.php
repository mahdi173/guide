<?php

/**
 * @ORM/Entity
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Journal
{

    const RESOURCE_KEY = 'journals';

    /**
     * @ORM/Id()
     * @ORM/GeneratedValue()
     * @ORM/Column(Type="integer")
     */
    private $id;

    /**
     *@ORM/Column(Type="String")
     */
    private $title;

    /**
     * @ORM/Column(Type="string")
     */
    private $ejr;

    /**
     * @ORM/Column(Type="string")
     */
    private $rank;

    /**
     * @ORM/Column(Type="string")
     */
    private $publisher;

    /**
     * @ORM/Column(Type="string")
     */
    private $openaccess;

    /**
     * @ORM/Column(Type="string")
     */
    private $p_issn;

    /**
     * @ORM/Column(Type="string")
     */
    private $e_issn;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
    public function setTitle($title): void
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
    public function getOpenaccess()
    {
        return $this->openaccess;
    }

    /**
     * @param mixed $openaccess
     */
    public function setOpenaccess($openaccess): void
    {
        $this->openaccess = $openaccess;
    }

    /**
     * @return mixed
     */
    public function getPIssn()
    {
        return $this->p_issn;
    }

    /**
     * @param mixed $p_issn
     */
    public function setPIssn($p_issn): void
    {
        $this->p_issn = $p_issn;
    }

    /**
     * @return mixed
     */
    public function getEIssn()
    {
        return $this->e_issn;
    }

    /**
     * @param mixed $e_issn
     */
    public function setEIssn($e_issn): void
    {
        $this->e_issn = $e_issn;
    }


}
