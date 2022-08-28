<?php

namespace App\Repository;

use App\Entity\Levels;
use App\Entity\User;
use Doctrine\ORM\ORMException;
use App\Repository\LevelsRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(User $entity, bool $flush = true): void
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
    public function remove(User $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
    
    public function getUserByEmail($email):array 
    { $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT u.id,u.email,u.roles FROM App\Entity\User u WHERE u.email = :email '
        )
        ->setParameter('email',$email);
        return $query->getResult();

    }
    public function count_users()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "select count(id) from user";
        $statement = $conn->prepare($sql);
        $resultSet = $statement->executeQuery();
        $a = $resultSet->fetchOne();
        return $a;
    }

    public function adminEmails(){
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT u FROM App\Entity\User u  where u.roles LIKE :role')
        ->setParameter('role', '%"'.'ROLE_ADMIN'.'"%');
    $e = $query->getResult(); 
    return $e ;// array of CmsUser ids
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
        /**
    * @return string
    */
    public function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
public function getUserVerifCode($id){
    $conn = $this->getEntityManager()
    ->getConnection();
$sql = "SELECT verification_code from user where id= ?";
$statement = $conn->prepare($sql);
$statement->bindValue(1, $id);
$resultSet = $statement->executeQuery();
$a = $resultSet->fetchOne();
return $a;

}
public function setValidUser($id){
    $conn = $this->getEntityManager()
    ->getConnection();
$sql = "UPDATE user SET verified = 1 WHERE id= ?";
$statement = $conn->prepare($sql);
$statement->bindValue(1, $id);
$resultSet = $statement->executeQuery();
$a = $resultSet->fetchOne();
return $a;

}
public function findOrCreateGoogleUser(ResourceOwnerInterface $owner): User
{$em =$this->getEntityManager();
   $user = $this->createQueryBuilder('u')
        ->where ('u.email = :email')
       ->setParameters([
           'email' => $owner->getEmail()
       ])
       ->getQuery ()
       ->getOneOrNullResult();
    if ($user) {
       return $user;

    }
    $user= (new User()) 
   ->setEmail($owner->getEmail())
   ->setLevels($em->getRepository(Levels::class)->getLevel(1))
   ->setFullName($owner->getFirstName().' '.$owner->getLastName())
   ->setRoles(['ROLE_EMPLOYEE']);

$em->persist($user);
$em->flush();
return $user;


}


}
