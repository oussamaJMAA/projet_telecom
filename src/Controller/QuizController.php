<?php

namespace App\Controller;

use App\Repository\QuizRepository;
use App\Repository\QuizQuestionsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuizController extends AbstractController
{
    /**
     * @Route("/quiz/info/{id}", name="app_quiz")
     */
    public function index(QuizQuestionsRepository $qr,$id): Response
    {dump($qr->getQuestions($id));
        return $this->render('quiz/index.html.twig', [
            'quizz' => $qr->getQuestions($id)
        ]);
    }
}
