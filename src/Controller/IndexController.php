<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="app_index")
     */
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
      /**
     * @Route("/testch" , name="chatbot")
     */
    public function chatbot(Request $request) :Response{
        exec('c:\WINDOWS\system32\cmd.exe /c python C:\Users\oussa\Downloads\chatbot-gui\chatbot-gui\app.py');
  
       // exec('c:\WINDOWS\system32\cmd.exe /c cd ');
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
       
       
    }
}
