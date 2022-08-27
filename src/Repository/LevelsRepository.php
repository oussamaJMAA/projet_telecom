<?php

namespace App\Repository;

use App\Entity\Levels;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Levels>
 *
 * @method Levels|null find($id, $lockMode = null, $lockVersion = null)
 * @method Levels|null findOneBy(array $criteria, array $orderBy = null)
 * @method Levels[]    findAll()
 * @method Levels[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LevelsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Levels::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Levels $entity, bool $flush = true): void
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
    public function remove(Levels $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Levels[] Returns an array of Levels objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Levels
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getLevel($l){
    
        $a= $this->createQueryBuilder('l')
            ->andWhere('l.difficulty = :val')
            ->setParameter('val', $l)
            ->getQuery()
            ->getOneOrNullResult();
           
        
        return $a ;
    }
    public function setUserLevel($id,$level){
     
            $conn = $this->getEntityManager()
                ->getConnection();
            $sql = "update user set levels_id = ? where id = ?";
            $statement = $conn->prepare($sql);
            $statement->bindValue(1, $level);
            $statement->bindValue(2, $id);
           return  $statement->executeQuery();


    }
}
