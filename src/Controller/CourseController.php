<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use Symfony\Component\Mime\Email;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/course")
 */
class CourseController extends AbstractController
{
    /**
     * @Route("/", name="app_course_index", methods={"GET"})
     */
    public function index(CourseRepository $courseRepository): Response
    {
     return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findAll(),
        ]);
    }

      /**
     * @Route("/course_front", name="app_course_index_front", methods={"GET"})
     */
    public function index_front(CourseRepository $courseRepository): Response
    {

     return $this->render('course/index_front.html.twig', [
            'courses' => $courseRepository->findAll(),
        ]);
    }

        /**
     * @Route("/course_front/liked/{id}/{user}", name="like_course", methods={"GET"})
     */
    public function like_course(CourseRepository $courseRepository,Course $course,$id,$user): Response
    {
        $courseRepository ->  like_course_($id);
        $courseRepository ->  likes_user_course_($id,$user);

        return $this->redirectToRoute('app_course_index_front_detailed', ['id'=>$id,'user'=>$user], Response::HTTP_SEE_OTHER);

    }

      /**
     * @Route("/{id}/{user}", name="app_course_index_front_detailed", methods={"GET"})
     */
    public function detailed_course(Course $course,$id,$user,CourseRepository $courseRepository): Response
    {

        $like_by_user_exist = $courseRepository ->  verif_likes_user_course_($id,$user);

        if($like_by_user_exist!=0){
            return $this->render('course/details_course.html.twig', [
                'course' => $course,
                'liked' =>1
              
            ]);
        }
        
        else{

        return $this->render('course/details_course.html.twig', [
            'course' => $course,
            'liked' =>0
        ]);
        }
    }

    /**
     * @Route("/new", name="app_course_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CourseRepository $courseRepository,MailerInterface $mailer): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
        $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );
        $course->setImage($fileName);
        $courseRepository->add($course);
       /* $email = (new Email())
        ->from('roukaia@gmail.com')
        ->to('roukaia.khelifi@esprit.tn')
        ->subject('Theres a new course check it out')
        ->html('<p>See Twig integration for better HTML integration!</p>');

    $mailer->send($email);
*/
        return $this->redirectToRoute('app_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('course/new.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_course_show", methods={"GET"})
     */
    public function show(Course $course): Response
    {
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_course_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Course $course, CourseRepository $courseRepository): Response
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseRepository->add($course);
            return $this->redirectToRoute('app_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('course/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_course_delete", methods={"POST"})
     */
    public function delete(Request $request, Course $course, CourseRepository $courseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$course->getId(), $request->request->get('_token'))) {
            $courseRepository->remove($course);
        }

        return $this->redirectToRoute('app_course_index', [], Response::HTTP_SEE_OTHER);
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
