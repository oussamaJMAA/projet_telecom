<?php

namespace App\Repository;

use DateTime;
use App\Entity\Quiz;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
    public function test($userId, $quiz_id, $score)

    {
        $today = date("Y-m-d");
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "insert into user_quiz(user_id,quiz_id,score,created_at) values(?,?,?,?)";
        $statement = $conn->prepare($sql);
        $statement->bindValue(1, $userId);
        $statement->bindValue(2, $quiz_id);
        $statement->bindValue(3, $score);
        $statement->bindValue(4, $today);
        return $statement->executeQuery();
    }
    public function test_update($userId, $quiz_id, $score)
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

    public function get_scores_users()
    {

        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select q.title quiz_t,u.full_name u_name,score from user_quiz uq,user u, quiz q where uq.user_id = u.id and uq.quiz_id = q.id order by score desc limit 6";
        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery();
        $a = $resultSet->fetchAllAssociative();

        return $a;
    }

    public function count1() {
        
        $conn=$this->getEntityManager()
                   ->getConnection();
                   $sql="SELECT count(extract(month from created_at)) as 'count' from user_quiz where extract(month from created_at) =1;";
                  
                   $stmt = $conn->query($sql);
                   $results = $stmt->fetchOne();
                   return $results;
 
}

public function count2() {
 
        $conn=$this->getEntityManager()
                   ->getConnection();
                   $sql="SELECT count(extract(month from created_at)) as 'count' from user_quiz where extract(month from created_at) =2;  ";
        
                   $stmt = $conn->query($sql);
                   $results = $stmt->fetchOne();
                   return $results;
   
   
}
public function count3() {
  
        $conn=$this->getEntityManager()
                   ->getConnection();
                   $sql="SELECT count(extract(month from created_at)) as 'count' from user_quiz where extract(month from created_at) =3;  ";
        
                   $stmt = $conn->query($sql);
                   $results = $stmt->fetchOne();
                   return $results;
    }
public function count4() {
  
        $conn=$this->getEntityManager()
                   ->getConnection();
                   $sql="SELECT count(extract(month from created_at)) as 'count' from user_quiz where extract(month from created_at) = 4;  ";
                   $stmt = $conn->query($sql);
                   $results = $stmt->fetchOne();
                   return $results;
   
}
public function count5() {
    
        $conn=$this->getEntityManager()
                   ->getConnection();
                   $sql="SELECT count(extract(month from created_at)) as 'count' from user_quiz where extract(month from created_at) =5;  ";
        
                   $stmt = $conn->query($sql);
                   $results = $stmt->fetchOne();
                   return $results;
   
}
public function count6() {
 
        $conn=$this->getEntityManager()
                   ->getConnection();
                   $sql="SELECT count(extract(month from created_at)) as 'count' from user_quiz where extract(month from created_at) = 6;  ";
                   $stmt = $conn->query($sql);
                   $results = $stmt->fetchOne();
                   return $results;
   
   
   
}
public function count7() {

        $conn=$this->getEntityManager()
                   ->getConnection();
                   $sql="SELECT count(extract(month from created_at)) as 'count' from user_quiz where extract(month from created_at) = 7;  ";
       
                   $stmt = $conn->query($sql);
                   $results = $stmt->fetchOne();
                   return $results;
   
}
public function count8() {

        $conn=$this->getEntityManager()
                   ->getConnection();
                   $sql="SELECT count(extract(month from created_at)) as 'count' from user_quiz where extract(month from created_at) = 8;  ";
                   $stmt = $conn->query($sql);
                   $results = $stmt->fetchOne();
                   return $results;
 
   
}
public function count9() {

        $conn=$this->getEntityManager()
                   ->getConnection();
                   $sql="SELECT count(extract(month from created_at)) as 'count' from user_quiz where extract(month from created_at) =9;  ";
        
                   $stmt = $conn->query($sql);
                   $results = $stmt->fetchOne();
                   return $results;
 
   
}
public function count10() {
 
        $conn=$this->getEntityManager()
                   ->getConnection();
                   $sql="SELECT count(extract(month from created_at)) as 'count' from user_quiz where extract(month from created_at) = 10;  ";
        
                   $stmt = $conn->query($sql);
                   $results = $stmt->fetchOne();
                   return $results;
   
}
public function count11() {
   
        $conn=$this->getEntityManager()
                   ->getConnection();
                   $sql="SELECT count(extract(month from created_at)) as 'count' from user_quiz where extract(month from created_at) =11;  ";
                   $stmt = $conn->query($sql);
                   $results = $stmt->fetchOne();
                   return $results;
}
public function count12() {
   
        $conn=$this->getEntityManager()
                   ->getConnection();
                   $sql="SELECT count(extract(month from created_at)) as 'count' from user_quiz where extract(month from created_at) =12;  ";
        
                   $stmt = $conn->query($sql);
                   $results = $stmt->fetchOne();
                   return $results;
   
}
public function barchart2(){
    $conn = $this->getEntityManager()
    ->getConnection();
     $sql = "
     select user_id ,user.full_name  name ,count(user_id)  count from user_quiz join user on user.id = user_quiz.user_id group by user_id";
     $statement = $conn->prepare($sql);
     $resultSet = $statement->executeQuery();
     $a = $resultSet->fetchAllAssociative();
     return $a;
}
public function get_question_level_of_user($l){
    $conn = $this->getEntityManager()
    ->getConnection();
     $sql = "
     select * from quiz_questions join quiz on quiz.id = quiz_questions.quiz_id where quiz.levels_id = ? limit 15";
     $statement = $conn->prepare($sql);
     $statement->bindValue(1, $l);
     $resultSet = $statement->executeQuery();
     $a = $resultSet->fetchAllAssociative();
     return $a;
}
public function UserScore($id){
    $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select sum(score)  -(select score from user_quiz where quiz_id = 2) from user_quiz where user_id = ? ;";
        $statement = $conn->prepare($sql);
        $statement->bindValue(1, $id);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;

}
public function UserScore2($id){
    $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select sum(score) from user_quiz where quiz_id > 21;";
        $statement = $conn->prepare($sql);
        $statement->bindValue(1, $id);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;

}
}
