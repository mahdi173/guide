<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FollowRepository")
 */
class Follow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="follows",cascade={"persist"})
     */
    private $followers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $following;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __construct()
    {
        $this->followers = new ArrayCollection();
    }
    public function getFollowing(): ?string
    {
        return $this->following;
    }

    public function setFollowing(string $following): self
    {
        $this->following = $following;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    public function addFollower(User $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
            $follower->addFollow($this);
        }

        return $this;
    }

    public function removeFollower(User $follower): self
    {
        if ($this->followers->contains($follower)) {
            $this->followers->removeElement($follower);
            $follower->removeFollow($this);
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getFollowing();
    }
}
