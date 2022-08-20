<?php

namespace App\Controller;

use App\Form\QuizFormType;
use App\Repository\QuizRepository;
use App\Repository\QuizQuestionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuizController extends AbstractController
{
    /**
     * @Route("/quiz/info/{id}", name="app_quiz")
     */
    public function index(QuizQuestionsRepository $qr, $id, Request $request, QuizRepository $qr2): Response
    { //dump($qr->getQuestions($id));

        $form = $this->createForm(QuizFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $score = $form->get('score')->getData();
            $qr2->test($score);
            




            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('quiz/index.html.twig', [
            'quizz' => $qr->getQuestions($id),
            'form' => $form->createView(),
            'quizzId' => $id,
            'userId' => $this->getUser()->getId()
        ]);
    }
    /**
     * @Route("/test/{value}", name="app_test22")
     */
    public function test22($value, QuizRepository $qr2)
    {
        $qr2->test($value);
        return $this->render('home/index.html.twig');
    }
}
