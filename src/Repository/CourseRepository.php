<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\ORM\ORMException;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Course>
 *
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Course $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Course $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function like_course_($idc)
    {

        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "update course set nb_likes = nb_likes+1 where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $idc);
        return $stmt->executeQuery();
    }
    public function likes_user_course_($idc, $idu)
    {

        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "insert into user_course (user_id,course_id) values(?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $idu);
        $stmt->bindValue(2, $idc);
        return $stmt->executeQuery();
    }
    public function unlike_course_($idc)
    {

        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "update course set nb_likes = nb_likes-1 where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $idc);
        return $stmt->executeQuery();
    }
    public function unlikes_user_course_($idc, $idu)
    {

        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "delete from user_course where user_id = ? and course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $idu);
        $stmt->bindValue(2, $idc);
        return $stmt->executeQuery();
    }
    public function verif_likes_user_course_($idc, $idu)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select count(user_id) from user_course where user_id = ? and course_id = ?";
        $statement = $conn->prepare($sql);
        $statement->bindValue(1, $idu);
        $statement->bindValue(2, $idc);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;
    }
    public function enroll_course_($idc)
    {

        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "update course set nb_enrollments = nb_enrollments+1 where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $idc);
        return $stmt->executeQuery();
    }
    public function enroll_user_course_($idc, $idu)
    {

        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "insert into enrollments (user,course) values(?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $idu);
        $stmt->bindValue(2, $idc);
        return $stmt->executeQuery();
    }
    public function verif_enroll_user_course_($idc, $idu)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select count(user) from enrollments where user= ? and course= ?";
        $statement = $conn->prepare($sql);
        $statement->bindValue(1, $idu);
        $statement->bindValue(2, $idc);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;
    }
    public function recent_courses()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select * from course order by id desc limit 3";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchAllAssociative();
        return $a;
    }
    public function count_courses()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select count(id) from course";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;
    }
    public function count_enrollments()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select count(id) from enrollments";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;
    }
    public function recent_courses_limit_6()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select * from course order by id desc limit 6";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchAllAssociative();
        return $a;
    }
    public function recent_courses_no_limit()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select * from course order by id desc";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchAllAssociative();
        return $a;
    }
    public function recommended_courses($user_id)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select course.* from course join quiz_course on quiz_course.course_id = course.id join quiz on quiz.id = quiz_course.quiz_id join user_quiz on user_quiz.quiz_id = quiz_course.quiz_id join user on user_quiz.user_id = user.id where user_quiz.score < 5 and user.id = ? group by course.name";
        $statement = $conn->prepare($sql);
        $statement->bindValue(1, $user_id);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchAllAssociative();
        return $a;
    }
    public function top_courses()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select * from course where nb_enrollments > (select avg(nb_enrollments) from course) order by nb_enrollments desc";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchAllAssociative();
        return $a;
    }

    // /**
    //  * @return Course[] Returns an array of Course objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Course
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function allCourses()
    {
        return $this->createQueryBuilder('c')
        ->orderBy('c.id', 'ASC');
    }
}
