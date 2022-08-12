<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/quizz")
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
     * create quiz rows from json files
     */
    
    // public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    // {
    //     $jsonRecu =file_get_contents("api.json");
    //     $arrayOfProperObjects = $serializer->deserialize($jsonRecu, Article::class.'[]', 'json');
    //     var_dump($arrayOfProperObjects);
    //     foreach ($arrayOfProperObjects as $article) {
    //         $em->persist($article);
    //         $em->flush();

    //     }
    //     return $this->json($article, 201, []);
    // }
}
