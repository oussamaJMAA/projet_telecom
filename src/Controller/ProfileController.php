<?php

namespace App\Controller;


use App\Form\ProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        
        
        
        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            
                        // moves the file to the directory where brochures are stored
                       $file->move(
                            $this->getParameter('brochures_directory'),
                            $fileName
                        );
            if ($form->get('fullName')->getData()) {
                $user->setFullName($form->get('fullName')->getData());
            }
            if ($form->get('password')->getData()) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }
            if ($form->get('phone')->getData()) {
                $user->setPhoneNumber($form->get('phone')->getData());
            }
            if ($form->get('experience')->getData()) {
                $user->setExperience($form->get('experience')->getData());
            }
            if ($form->get('details')->getData()) {
                $user->setDetails($form->get('details')->getData());
            }       
            if ($file) {

                $user->setPhoto($fileName);
            }
            $em->persist($user);
            $em->flush();
            return $this->redirect($request->getUri());
        }

        return $this->render('profile/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}