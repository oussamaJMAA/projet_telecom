<?php

namespace App\Entity;

use App\Repository\LevelsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LevelsRepository::class)
 */
class Levels
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $difficulty;

    /**
     * @ORM\OneToMany(targetEntity=user::class, mappedBy="levels")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=course::class, mappedBy="levels")
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity=quiz::class, mappedBy="levels")
     */
    private $quiz;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->course = new ArrayCollection();
        $this->quiz = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(int $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(user $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setLevels($this);
        }

        return $this;
    }

    public function removeUser(user $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLevels() === $this) {
                $user->setLevels(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, course>
     */
    public function getCourse(): Collection
    {
        return $this->course;
    }

    public function addCourse(course $course): self
    {
        if (!$this->course->contains($course)) {
            $this->course[] = $course;
            $course->setLevels($this);
        }

        return $this;
    }

    public function removeCourse(course $course): self
    {
        if ($this->course->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getLevels() === $this) {
                $course->setLevels(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, quiz>
     */
    public function getQuiz(): Collection
    {
        return $this->quiz;
    }

    public function addQuiz(quiz $quiz): self
    {
        if (!$this->quiz->contains($quiz)) {
            $this->quiz[] = $quiz;
            $quiz->setLevels($this);
        }

        return $this;
    }

    public function removeQuiz(quiz $quiz): self
    {
        if ($this->quiz->removeElement($quiz)) {
            // set the owning side to null (unless already changed)
            if ($quiz->getLevels() === $this) {
                $quiz->setLevels(null);
            }
        }

        return $this;
    }
}
