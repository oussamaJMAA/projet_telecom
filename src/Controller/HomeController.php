<?php

namespace App\Controller;



use Twilio\Rest\Client;
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
     $account_sid = 'AC98154bf72bc4fd663711706599cb305b';
$auth_token = '742d3e31b094511b619e19d9ce068f9d';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

// A Twilio number you own with SMS capabilities
$twilio_number = "+16067290629";

$client = new Client($account_sid, $auth_token);
$client->messages->create(
    // Where to send a text message (your cell phone?)
    '+21655919740',
    array(
        'from' => $twilio_number,
        'body' => 'I sent this message in under 10 minutes!'
    )
);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'courses' => $courseRepository->recent_courses()

        ]);
    }
}
