<?php

namespace App\Controller;

use App\Repository\HistoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HistoryController extends AbstractController
{
    /**
     * @Route("/history", name="app_history")
     */
    public function index(HistoryRepository $h): Response
    { 
        
        return $this->render('history/index.html.twig', [
            'history' => $h->findByExampleField($this->getUser()->getId())
        ]);
    }
}
