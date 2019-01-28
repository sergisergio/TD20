<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class Person
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movie", mappedBy="Director", orphanRemoval=true)
     */
    private $movies;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movie", mappedBy="actors")
     */
    private $actorMovies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
        $this->moviesProduced = new ArrayCollection();
        $this->actorMovies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->setDirector($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->contains($movie)) {
            $this->movies->removeElement($movie);
            // set the owning side to null (unless already changed)
            if ($movie->getDirector() === $this) {
                $movie->setDirector(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getActorMovies(): Collection
    {
        return $this->actorMovies;
    }

    public function addActorMovie(Movie $actorMovie): self
    {
        if (!$this->actorMovies->contains($actorMovie)) {
            $this->actorMovies[] = $actorMovie;
            $actorMovie->addActor($this);
        }

        return $this;
    }

    public function removeActorMovie(Movie $actorMovie): self
    {
        if ($this->actorMovies->contains($actorMovie)) {
            $this->actorMovies->removeElement($actorMovie);
            $actorMovie->removeActor($this);
        }

        return $this;
    }
}
