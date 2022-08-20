<?php

namespace App\Repository;

use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quiz>
 *
 * @method Quiz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quiz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quiz[]    findAll()
 * @method Quiz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Quiz $entity, bool $flush = true): void
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
    public function remove(Quiz $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function count_Quizz()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select count(id) from quiz";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;
    }
    // /**
    //  * @return Quiz[] Returns an array of Quiz objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Quiz
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function test($userId,$quiz_id,$score)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "insert into user_quiz(user_id,quiz_id,score) values(?,?,?)";
        $statement = $conn->prepare($sql);
        $statement->bindValue(1, $userId);
        $statement->bindValue(2, $quiz_id);
        $statement->bindValue(3, $score);
       return $statement->executeQuery();
       
    }
    public function test_update($userId,$quiz_id,$score)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "update user_quiz set score = ? where user_id =  ? and quiz_id = ?";
        $statement = $conn->prepare($sql);
        $statement->bindValue(1, $score);
        $statement->bindValue(2, $userId);
        $statement->bindValue(3, $quiz_id);
       return $statement->executeQuery();
       
    }
    // public function chart2(){
    //     $conn = $this->getEntityManager()
    //     ->getConnection();
    // $sql = "select count(user_id) as count,score from user_quiz group by (score)";
    // $statement = $conn->prepare($sql);
    // $resultSet = $statement->executeQuery();
    // $a = $resultSet->fetchAllAssociative();
    // return $a;

    // }
    public function got_score_0_()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select count(user_id) from user_quiz where score=0";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;
    }
    public function got_score_1_()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select count(user_id) from user_quiz where score=1";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;
    }
    public function got_score_2_()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select count(user_id) from user_quiz where score=2";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;
    }
    public function got_score_3_()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select count(user_id) from user_quiz where score=3";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;
    }
    public function got_score_4_()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select count(user_id) from user_quiz where score=4";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;
    }
    public function got_score_5_()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select count(user_id) from user_quiz where score=5";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;
    }

    public function get_scores_users(){

        $conn = $this->getEntityManager()
        ->getConnection();
        $sql = "select q.title quiz_t,u.full_name u_name,score from user_quiz uq,user u, quiz q where uq.user_id = u.id and uq.quiz_id = q.id";
        $stmt = $conn->prepare($sql);
      
        $resultSet = $stmt->executeQuery();
        $a= $resultSet->fetchAllAssociative();

    return $a;
    }
}
