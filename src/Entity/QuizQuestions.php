<?php

namespace App\Entity;

use App\Repository\QuizQuestionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizQuestionsRepository::class)
 */
class QuizQuestions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $QuestID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $choiceA;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $choiceB;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $choiceC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $choiceD;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CorrectAnswer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Explanation;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="questions")
     */
    private $quiz;


    public function getQuestID(): ?int
    {
        return $this->QuestID;
    }

    public function getQuestion(): ?string
    {
        return $this->Question;
    }

    public function setQuestion(string $Question): self
    {
        $this->Question = $Question;

        return $this;
    }

    public function getChoiceA(): ?string
    {
        return $this->choiceA;
    }

    public function setChoiceA(string $choiceA): self
    {
        $this->choiceA = $choiceA;

        return $this;
    }

    public function getChoiceB(): ?string
    {
        return $this->choiceB;
    }

    public function setChoiceB(string $choiceB): self
    {
        $this->choiceB = $choiceB;

        return $this;
    }

    public function getChoiceC(): ?string
    {
        return $this->choiceC;
    }

    public function setChoiceC(?string $choiceC): self
    {
        $this->choiceC = $choiceC;

        return $this;
    }

    public function getChoiceD(): ?string
    {
        return $this->choiceD;
    }

    public function setChoiceD(?string $choiceD): self
    {
        $this->choiceD = $choiceD;

        return $this;
    }

    public function getCorrectAnswer(): ?string
    {
        return $this->CorrectAnswer;
    }

    public function setCorrectAnswer(string $CorrectAnswer): self
    {
        $this->CorrectAnswer = $CorrectAnswer;

        return $this;
    }

    public function getExplanation(): ?string
    {
        return $this->Explanation;
    }

    public function setExplanation(string $Explanation): self
    {
        $this->Explanation = $Explanation;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }
}
