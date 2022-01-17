<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Journal
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\JournalRepository")
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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ejr;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $publisher;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $openaccess;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $printissn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $eissn;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $rank;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $link;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
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
    public function getPrintissn()
    {
        return $this->printissn;
    }

    /**
     * @param mixed $printissn
     */
    public function setPrintissn($printissn): void
    {
        $this->printissn = $printissn;
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
