<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request,UserRepository $userRepository,MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);
        $adminEmails = $userRepository->adminEmails();
        if ($form->isSubmitted() && $form->isValid()) {
        
          
            foreach ($adminEmails as $adminEmail) {
    
                $email = (new Email())
    
                    ->from($form->get('email')->getData())
                    ->to($adminEmail->getEmail())
                    ->subject($form->get('subject')->getData())
                    ->text('Sending email')
                    ->html($this->renderview('contact/email.html.twig', [
                        'msg' =>  $form->get('message')->getData(),
                        'username' => $form->get('name')->getData(),
                        'phone' => $form->get('phone')->getData()
                    ]));
                $mailer->send($email);
            }
        
            return $this->redirect($request->getUri());
        
        }
        return $this->render('contact/index.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
