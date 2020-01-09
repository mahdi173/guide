<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sulu\Bundle\SecurityBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * User
 *
 * @ORM\Table(name="se_users")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     */
    private $oldPassword;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $institution;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $departement;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $speciality;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Publication", mappedBy="user")
     */
    private $publications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="user")
     */
    private $books;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chapter", mappedBy="user")
     */
    private $chapters;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Conference", mappedBy="user")
     */
    private $conferences;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DataTScopus", inversedBy="users")
     */
    private $favoriteScopusJournals;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\DataReuters", inversedBy="users")
     */
    private $favoriteReutersJournals;


    public function __construct()
    {
        parent::__construct();
        $this->publications = new ArrayCollection();
        $this->books = new ArrayCollection();
        $this->chapters = new ArrayCollection();
        $this->conferences = new ArrayCollection();
        $this->favoriteScopusJournals = new ArrayCollection();
        $this->favoriteReutersJournals = new ArrayCollection();
    }

    public function setEmail($email)
    {
        $this->setUsername($email);

        return parent::setEmail($email);
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * @param string $departement
     */
    public function setDepartement($departement): void
    {
        $this->departement = $departement;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName($fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return string
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * @param string $institution
     */
    public function setInstitution($institution): void
    {
        $this->institution = $institution;
    }

    /**
     * @return string
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * @param string $speciality
     */
    public function setSpeciality($speciality): void
    {
        $this->speciality = $speciality;
    }

    /**
     * @return Collection|Publication[]
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): self
    {
        if (!$this->publications->contains($publication)) {
            $this->publications[] = $publication;
            $publication->setRelation($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): self
    {
        if ($this->publications->contains($publication)) {
            $this->publications->removeElement($publication);
            // set the owning side to null (unless already changed)
            if ($publication->getRelation() === $this) {
                $publication->setRelation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setUser($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            // set the owning side to null (unless already changed)
            if ($book->getUser() === $this) {
                $book->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Chapter[]
     */
    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapter $chapter): self
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters[] = $chapter;
            $chapter->setUser($this);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter): self
    {
        if ($this->chapters->contains($chapter)) {
            $this->chapters->removeElement($chapter);
            // set the owning side to null (unless already changed)
            if ($chapter->getUser() === $this) {
                $chapter->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Conference[]
     */
    public function getConferences(): Collection
    {
        return $this->conferences;
    }

    public function addConference(Conference $conference): self
    {
        if (!$this->conferences->contains($conference)) {
            $this->conferences[] = $conference;
            $conference->setUser($this);
        }

        return $this;
    }

    public function removeConference(Conference $conference): self
    {
        if ($this->conferences->contains($conference)) {
            $this->conferences->removeElement($conference);
            // set the owning side to null (unless already changed)
            if ($conference->getUser() === $this) {
                $conference->setUser(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        $str = ''.$this->getFullName();

        if (empty($str)) {
            $str = $this->getEmail();
        }

        return $str;
    }

    public function getFullAdress()
    {
        if (Countries::exists($this->getCountry())) {
            return Countries::getName($this->getCountry());
        }

        return '';
    }

    /**
     * @return Collection|DataTScopus[]
     */
    public function getFavoriteScopusJournals(): Collection
    {
        return $this->favoriteScopusJournals;
    }

    public function addFavoriteScopusJournal(DataTScopus $favoriteScopusJournal): self
    {
        if (!$this->favoriteScopusJournals->contains($favoriteScopusJournal)) {
            $this->favoriteScopusJournals[] = $favoriteScopusJournal;
        }

        return $this;
    }

    public function removeFavoriteScopusJournal(DataTScopus $favoriteScopusJournal): self
    {
        if ($this->favoriteScopusJournals->contains($favoriteScopusJournal)) {
            $this->favoriteScopusJournals->removeElement($favoriteScopusJournal);
        }

        return $this;
    }

    /**
     * @return Collection|DataReuters[]
     */
    public function getFavoriteReutersJournals(): Collection
    {
        return $this->favoriteReutersJournals;
    }

    public function addFavoriteReutersJournal(DataReuters $favoriteReutersJournal): self
    {
        if (!$this->favoriteReutersJournals->contains($favoriteReutersJournal)) {
            $this->favoriteReutersJournals[] = $favoriteReutersJournal;
        }

        return $this;
    }

    public function removeFavoriteReutersJournal(DataReuters $favoriteReutersJournal): self
    {
        if ($this->favoriteReutersJournals->contains($favoriteReutersJournal)) {
            $this->favoriteReutersJournals->removeElement($favoriteReutersJournal);
        }

        return $this;
    }

}
