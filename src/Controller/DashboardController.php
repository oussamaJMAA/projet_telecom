<?php

namespace App\Controller;

use App\Repository\QuizRepository;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index(CourseRepository $courseRepository,QuizRepository $q,UserRepository $u): Response
    {dump($q->chart2());
        return $this->render('dashboard/index.html.twig', [

            'controller_name' => 'DashboardController',
            'nb_courses' => $courseRepository->count_courses(),
            'nb_enrollments' => $courseRepository->count_enrollments(),
            'nb_quizz' => $q->count_Quizz(),
            'nb_users' => $u->count_users(),
            'recent_courses' => $courseRepository-> recent_courses_limit_4(),
            'arr'=> $q->chart2()
        ]);
    }
}
