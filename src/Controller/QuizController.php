<?php

namespace App\Controller;

use Exception;
use App\Entity\History;
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
    { 
      if($this->getUser()){
        
        $level_of_user = $this->getUser()->getLevels()->getDifficulty();
      $history = new History();
      $ar =[];
      //dump($qr2->get_question_level_of_user($level_of_user));
        foreach($qr2->get_question_level_of_user($level_of_user) as $element ){
          array_push($ar, $element['question']);
           
        }
           $entityManager = $this->getDoctrine()->getManager();
        foreach($ar as $element ){
            $history = new History();
            $history->setUser($this->getUser()->getId());
            $history->setQuestion( $element);
            $entityManager->persist($history);
          }

         
          $entityManager->flush();

        

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
  
}
