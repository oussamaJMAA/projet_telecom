<?php

namespace App\Controller;

use Exception;
use App\Form\QuizFormType;
use App\Entity\QuizQuestions;
use App\Form\QuizQuestionsType;
use App\Repository\QuizRepository;
use App\Repository\LevelsRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function quizz_front(EntityManagerInterface $em, LevelsRepository $levelRepository, Request $request, QuizRepository $qr, QuizQuestionsRepository $qqr): Response
    {
        if ($this->getUser()) {
            $level_of_user = $this->getUser()->getLevels()->getDifficulty();
            if ($level_of_user == 1) {
                $form = $this->createForm(QuizFormType::class);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $score = $form->get('score')->getData();
                    if ($score <= 7) {

                        $levelRepository->setUserLevel($this->getUser()->getId(), 2);
                    } else if ($score >= 12) {
                        $levelRepository->setUserLevel($this->getUser()->getId(), 4);
                    } else {
                        $levelRepository->setUserLevel($this->getUser()->getId(), 3);
                    }
                    try {
                        $qr->test($this->getUser()->getId(), 2, $score);
                    } catch (Exception $e) {
                        //         dump($e);
                        $qr->test_update($this->getUser()->getId(), 2, $score);
                    }

                    return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
                }



                return $this->render('home/quizz_level1.html.twig', [
                    'questions' => $qr->get_question_level_of_user($level_of_user),
                    'form' => $form->createView(),

                ]);
            }
            
if (($level_of_user == 2) && ($qr->UserScore($this->getUser()->getId())==50))
{$levelRepository->setUserLevel($this->getUser()->getId(), 3);
}
if (($level_of_user == 3) && ($qr->UserScore2($this->getUser()->getId())==65))
{$levelRepository->setUserLevel($this->getUser()->getId(), 4);
}
        
            return $this->render('home/quizz_front.html.twig', [
                'quizz' => $qr->findByLevels($level_of_user),

            ]);
        }
        return $this->redirectToRoute('app_login');
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
