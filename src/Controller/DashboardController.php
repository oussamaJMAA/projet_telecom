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
    {//exec('c:\WINDOWS\system32\cmd.exe /c start C:\Users\oussa\AppData\Local\Programs\"Opera GX"\launcher.exe');
       dump($q->barchart2()[0]['name']);

        return $this->render('dashboard/index.html.twig', [

            'controller_name' => 'DashboardController',
            'nb_courses' => $courseRepository->count_courses(),
            'nb_enrollments' => $courseRepository->count_enrollments(),
            'nb_quizz' => $q->count_Quizz(),
            'nb_users' => $u->count_users(),
            'recent_courses' => $courseRepository-> recent_courses_limit_4(),
            'score_0'=>$q->got_score_0_(),
            'score_1'=>$q->got_score_1_(),
            'score_2'=>$q->got_score_2_(),
            'score_3'=>$q->got_score_3_(),
            'score_4'=>$q->got_score_4_(),
            'score_5'=>$q->got_score_5_(),
            'users_scores'=>$q->get_scores_users(),
            'n1' => $q->count1(),
            'n2' => $q->count2(),
            'n3' => $q->count3(),
            'n4' => $q->count4(),
            'n5' => $q->count5(),
            'n6' => $q->count6(),
            'n7' => $q->count7(),
            'n8' => $q->count8(),
            'n9' => $q->count9(),
            'n10' => $q->count10(),
            'n11' => $q->count11(),
            'n12' => $q->count12(),
            'b2' => $q->barchart2(),
            'f1' => $q->barchart2()[0]['name'],
            'f2'=> $q->barchart2()[1]['name'],
            'c1' => $q->barchart2()[0]['count'],
            'c2' => $q->barchart2()[1]['count'],
            'c3' => $q->barchart2()[2]['count'],
            'c4' => $q->barchart2()[3]['count'],
            'array'=> $q->barchart2()
        ]);
    }
}
