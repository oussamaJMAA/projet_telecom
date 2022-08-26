<?php

namespace App\Controller;

use App\Entity\QuizQuestions;
use App\Form\QuizQuestionsType;
use App\Repository\QuizRepository;
use App\Repository\QuizQuestionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/quiz/questions")
 */
class QuizQuestionsController extends AbstractController
{
    /**
     * @Route("/", name="app_quiz_questions_index", methods={"GET"})
     */
    public function index(QuizQuestionsRepository $quizQuestionsRepository): Response
    {
        return $this->render('quiz_questions/index.html.twig', [
            'quizz' => $quizQuestionsRepository->findAll(),
        ]);
    }

    
    /**
     * @Route("/employee", name="quizz_front")
     */
    public function quizz_front(QuizRepository $qr,QuizQuestionsRepository $qqr): Response
    {
        if($this->getUser()){
            $level_of_user = $this->getUser()->getLevels()->getDifficulty();
        return $this->render('home/quizz_front.html.twig',[
            'quizz' => $qr->findByLevels($level_of_user),
         
        ]);
    } return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/new", name="app_quiz_questions_new", methods={"GET", "POST"})
     */
    public function new(Request $request, QuizQuestionsRepository $quizQuestionsRepository): Response
    {
        $quizQuestion = new QuizQuestions();
        $form = $this->createForm(QuizQuestionsType::class, $quizQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quizQuestionsRepository->add($quizQuestion);
            return $this->redirectToRoute('app_quiz_questions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quiz_questions/new.html.twig', [
            'quiz_question' => $quizQuestion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{QuestID}", name="app_quiz_questions_show", methods={"GET"})
     */
    public function show(QuizQuestions $quizQuestion): Response
    {
        return $this->render('quiz_questions/show.html.twig', [
            'quiz_question' => $quizQuestion,
        ]);
    }

    /**
     * @Route("/{QuestID}/edit", name="app_quiz_questions_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, QuizQuestions $quizQuestion, QuizQuestionsRepository $quizQuestionsRepository): Response
    {
        $form = $this->createForm(QuizQuestionsType::class, $quizQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quizQuestionsRepository->add($quizQuestion);
            return $this->redirectToRoute('app_quiz_questions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quiz_questions/edit.html.twig', [
            'quiz_question' => $quizQuestion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{QuestID}", name="app_quiz_questions_delete", methods={"POST"})
     */
    public function delete(Request $request, QuizQuestions $quizQuestion, QuizQuestionsRepository $quizQuestionsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $quizQuestion->getQuestID(), $request->request->get('_token'))) {
            $quizQuestionsRepository->remove($quizQuestion);
        }

        return $this->redirectToRoute('app_quiz_questions_index', [], Response::HTTP_SEE_OTHER);
    }
}
