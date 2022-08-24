<?php

namespace App\Controller;

use DateTime;
use App\Entity\Course;
use App\Entity\Comment;
use App\Form\CourseType;
use App\Form\CommentType;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Mime\Email;
use App\Repository\CourseRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
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
     * @Route("/details/{id}", name="app_course_index_front_detailed", methods={"GET", "POST"})
     */
    public function detailed_course(CommentRepository $commentRepository, Course $course, $id, CourseRepository $courseRepository, Request $request): Response
    {
        $comment = new Comment();
        $entityManager = $this->getDoctrine()->getManager();
        if ($this->getUser()) {
            $form = $this->createForm(CommentType::class, $comment);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $comment->setContent( $form->get('content')->getData());
                $comment->setCourse($course);
                $comment->setAuthor($this->getUser());
                $comment->setCreatedAt(new DateTime());
                $entityManager->persist($comment);
                $entityManager->flush();
                return $this->redirect($request->getUri());
            }

            $enrolled_by_user = $courseRepository->verif_enroll_user_course_($id, $this->getUser()->getId());
            $like_by_user_exist = $courseRepository->verif_likes_user_course_($id, $this->getUser()->getId());
            if ($like_by_user_exist != 0 && $enrolled_by_user != 0) {
                $liked = 1;
                $enrolled = 1;
            } else if ($like_by_user_exist == 0 && $enrolled_by_user == 0) {
                $liked = 0;
                $enrolled = 0;
            } else if ($like_by_user_exist == 0 && $enrolled_by_user != 0) {
                $liked = 0;
                $enrolled = 1;
            } else {
                $liked = 1;
                $enrolled = 0;
            }

            return $this->render('course/details_course.html.twig', [
                'course' => $course,
                'liked' => $liked,
                'enrolled' => $enrolled,
                'form' => $form->createView(),
                

            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
    /**
     * @Route("/course_front/{page<\d+>}", name="app_course_index_front", methods={"GET"})
     */
    public function index_front(CourseRepository $courseRepository, int $page = 1): Response
    {
        $pagerfanta = new Pagerfanta(new QueryAdapter($courseRepository->allCourses()));
        $pagerfanta->setMaxPerPage(6);
        $pagerfanta->setCurrentPage($page);

        return $this->render('course/index_front.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }
    /**
     * @Route("/course_front/rec", name="app_course_index_front_rec", methods={"GET"})
     */
    public function recommended(CourseRepository $courseRepository): Response
    {
        if ($this->getUser()) {
            return $this->render('course/recommended.html.twig', [
                'courses' => $courseRepository->recommended_courses($this->getUser()->getId()),
            ]);
        }
        return $this->redirectToRoute('app_login');
    }
    /**
     * @Route("/course_front/top", name="top", methods={"GET"})
     */
    public function top_courses(CourseRepository $courseRepository): Response
    {

        return $this->render('course/top_courses.html.twig', [
            'courses' => $courseRepository->top_courses(),
        ]);
    }
    /**
     * @Route("/course_front/recent", name="recent", methods={"GET"})
     */
    public function recent_courses(CourseRepository $courseRepository): Response
    {

        return $this->render('course/recent_courses.html.twig', [
            'courses' => $courseRepository->recent_courses_limit_6(),
        ]);
    }

    /**
     * @Route("/new", name="app_course_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CourseRepository $courseRepository): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );
            $course->setImage($fileName);
            $courseRepository->add($course);

            return $this->redirectToRoute('app_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('course/new.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/course_front/liked/{id}", name="like_course", methods={"GET"})
     */
    public function like_course(CourseRepository $courseRepository, Course $course, $id): Response
    {
        if ($this->getUser()) {
            $courseRepository->like_course_($id);
            $courseRepository->likes_user_course_($id, $this->getUser()->getId());

            return $this->redirectToRoute('app_course_index_front_detailed', ['id' => $id, 'user' => $this->getUser()->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/course_front/unliked/{id}", name="unlike_course", methods={"GET"})
     */
    public function unlike_course(CourseRepository $courseRepository, Course $course, $id): Response
    {
        $courseRepository->unlike_course_($id);
        $courseRepository->unlikes_user_course_($id, $this->getUser()->getId());

        return $this->redirectToRoute('app_course_index_front_detailed', ['id' => $id, 'user' => $this->getUser()->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/course_front/enrolled/{id}", name="enroll_course", methods={"GET"})
     */
    public function enroll_course(CourseRepository $courseRepository, Course $course, $id): Response
    {
        if ($this->getUser()) {
            $courseRepository->enroll_course_($id);
            $courseRepository->enroll_user_course_($id, $this->getUser()->getId());

            return $this->redirectToRoute('app_course_index_front_detailed', ['id' => $id, 'user' => $this->getUser()->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->redirectToRoute('app_login');
    }
    /**
     * @Route("/course_front/continue/{id}", name="continue_course", methods={"GET"})
     */
    public function continue_course(CourseRepository $courseRepository, Course $course, $id): Response
    {
        return $this->redirectToRoute('app_course_index_front_detailed', ['id' => $id, 'user' => $this->getUser()->getId()], Response::HTTP_SEE_OTHER);
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
        if ($this->isCsrfTokenValid('delete' . $course->getId(), $request->request->get('_token'))) {
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
