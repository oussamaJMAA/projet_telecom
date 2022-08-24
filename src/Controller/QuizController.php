<?php

namespace App\Controller;

use Exception;
use App\Entity\Quiz;
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
if($this->getUser()){
        $form = $this->createForm(QuizFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $score = $form->get('score')->getData();
            try{
            $qr2->test($this->getUser()->getId(),$id,$score);
            
        }
        catch (Exception $e) {
  //         dump($e);
          $qr2->test_update($this->getUser()->getId(),$id,$score);
        }
        return $this->redirectToRoute('quizz_front', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('quiz/index.html.twig', [
            'quizz' => $qr->getQuestions($id),
            'form' => $form->createView(),
          
        ]);
    }
    return $this->redirectToRoute('app_login');
    }
     /**
     * @Route("/quiz/all", name="all_quizes", methods={"GET"})
     */
    public function index_back(QuizRepository $quizRepository): Response
    {
        return $this->render('quiz/all.html.twig', [
            'quizz' => $quizRepository->findAll(),
        ]);
    }
    /**
     * @Route("/quiz_/new", name="new_quiz", methods={"GET", "POST"})
     */
    public function new(Request $request, QuizRepository $quizRepository): Response
    {
        $quizQuestion = new Quiz();
        $form = $this->createForm(QuizFormType::class, $quizQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quizRepository->add($quizQuestion);
            return $this->redirectToRoute('app_quiz_questions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quiz/new.html.twig', [
            'quiz' => $quizQuestion,
            'form' => $form->createView(),
        ]);
    }

}
