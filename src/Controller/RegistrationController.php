<?php

namespace App\Controller;

use App\Entity\User;
use Twilio\Rest\Client;
use App\Form\VerifFormType;
use App\Security\Authenticator;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegistrationController extends AbstractController
{ public function __construct( UrlGeneratorInterface $urlGenerator)
    {
      
        $this->urlGenerator = $urlGenerator;
       
   
    }


    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, GuardAuthenticatorHandler $guardHandler, Authenticator $authenticator, EntityManagerInterface $entityManager,UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(array('ROLE_EMPLOYEE'));
            $user -> setLevels(1); //set level to nothing at first (1) because he didnt even begin any quiz
            $verif_code = $userRepository->generateRandomString(6);
            $user->setVerificationCode($verif_code);
            $account_sid = 'AC98154bf72bc4fd663711706599cb305b';
            $auth_token = 'd7a8ffe9c2071a47b942969e0c224230';
            // In production, these should be environment variables. E.g.:
            // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
            
            // A Twilio number you own with SMS capabilities
            $twilio_number = "+16067290629";
            
            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                // Where to send a text message (your cell phone?)
                '+216'.$form->get('phoneNumber')->getData(),
                array(
                    'from' => $twilio_number,
                    'body' => 'Verification code : '.$verif_code
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $this->addFlash('success', 'Text message is sent to +216'.$form->get('phoneNumber')->getData());
           // return $this->redirectToRoute('app_verif');

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
            
          
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    

/**
     * @Route("/verify/code/{id}", defaults={"id" = null} ,name="app_verif")
     */
    public function verifyCode(Request $request,UserRepository $userRepository,$id):Response
    {  $form = $this->createForm(VerifFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if($form->get('verif')->getData()==$userRepository->getUserVerifCode($id) ){
                $this->addFlash(
                    'success',
                    'Verification code is correct'
                );
                return $this->redirectToRoute('app_home');
            }
            else {
                $this->addFlash(
                    'error',
                    'Verification code is incorrect'
                );
                return new RedirectResponse($this->urlGenerator->generate('app_verif', array('id' => $id)));
            }
        }
        return $this->render('registration/verif.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
        }
    

  
}
