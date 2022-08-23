<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_enrollments = 0;

    /**
     * @ORM\Column(type="text")

     */
    private $details;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     * pattern = "/^(http:|https:|www.)/",
     * match="false",
     * message="lien nest pas valide"
     * )
     */
    private $link;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_likes = 0;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="likes")
     *  @ORM\JoinColumn(name="id", referencedColumnName="id",onDelete="cascade")
     *  
     */
    private $liked_courses;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rate;

    /**
     * @ORM\ManyToMany(targetEntity=Quiz::class, inversedBy="courses")
     */
    private $related_quiz;

  

    public function __construct()
    {
        $this->liked_courses = new ArrayCollection();
        $this->related_quiz = new ArrayCollection();
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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getNbEnrollments(): ?int
    {
        return $this->nb_enrollments;
    }

    public function setNbEnrollments(?int $nb_enrollments): self
    {
        $this->nb_enrollments = $nb_enrollments;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getNbLikes(): ?int
    {
        return $this->nb_likes;
    }

    public function setNbLikes(int $nb_likes): self
    {
        $this->nb_likes = $nb_likes;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikedCourses(): Collection
    {
        return $this->liked_courses;
    }

    public function addLikedCourse(User $likedCourse): self
    {
        if (!$this->liked_courses->contains($likedCourse)) {
            $this->liked_courses[] = $likedCourse;
            $likedCourse->addLike($this);
        }

        return $this;
    }

    public function removeLikedCourse(User $likedCourse): self
    {
        if ($this->liked_courses->removeElement($likedCourse)) {
            $likedCourse->removeLike($this);
        }

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(?float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return Collection<int, quiz>
     */
    public function getRelatedQuiz(): Collection
    {
        return $this->related_quiz;
    }

    public function addRelatedQuiz(quiz $relatedQuiz): self
    {
        if (!$this->related_quiz->contains($relatedQuiz)) {
            $this->related_quiz[] = $relatedQuiz;
        }

        return $this;
    }

    public function removeRelatedQuiz(quiz $relatedQuiz): self
    {
        $this->related_quiz->removeElement($relatedQuiz);

        return $this;
    }


}
