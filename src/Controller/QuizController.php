<?php

namespace App\Controller;


use App\Entity\QuizQuestions;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\QuizQuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/quiz", name="app_quiz")
 */
class QuizController extends AbstractController
{
    /**
     * @Route("/", name="app_quiz")
     */
    public function index(): Response
    {
        return $this->render('quiz/index.html.twig', [
            'controller_name' => 'QuizController',
        ]);
    }


    /**
     * @Route("/new", name="app_new_quiz")
     */
    
    // public function store(Request $request, QuizQuestionsRepository $quizQuestionsRepository)
    // {
    //     $quizQuest = new QuizQuestions();        
    //     $form = $this->createForm(QuestionType::class, $quizQuest);
    //     $form->handleRequest($request);
        
    //     if ($form->isSubmitted() && $form->isValid()) 
    //     {
    //         $file = $form->get('image')->getData();
    //         $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

    //         // moves the file to the directory where brochures are stored
    //         $file->move(
    //             $this->getParameter('brochures_directory'),
    //             $fileName
    //         );
    //         $quizQuest->setImage($fileName);
    //         $courseRepository->add($quizQuest);
            
    //         return $this->redirectToRoute('quiz', [], Response::HTTP_SEE_OTHER);
    //     }
    // }
}
