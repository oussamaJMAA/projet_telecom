<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     * @Route("/", name="app_home")
     */
    public function index(CourseRepository $courseRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'courses' => $courseRepository -> recent_courses()

        ]);
    }
}
