<?php

namespace App\Repository;

use App\Entity\QuizQuestions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuizQuestions>
 *
 * @method QuizQuestions|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizQuestions|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizQuestions[]    findAll()
 * @method QuizQuestions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizQuestionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizQuestions::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(QuizQuestions $entity, bool $flush = true): void
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
    public function remove(QuizQuestions $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return QuizQuestions[] Returns an array of QuizQuestions objects
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
    public function findOneBySomeField($value): ?QuizQuestions
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getQuestions($id){

        $conn = $this->getEntityManager()
        ->getConnection();
        $sql = "select * from quiz_questions where quiz_id = ? ORDER BY RAND() limit 5 ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $resultSet = $stmt->executeQuery();
        $a= $resultSet->fetchAllAssociative();

    return $a;
    }
}
