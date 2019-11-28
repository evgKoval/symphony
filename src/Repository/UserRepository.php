<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    
    public function findOneByEmail($email)
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }
    

    public function findOneByEmailAndPassword($email, $password)
    {
        return $this->createQueryBuilder('u')
            ->select(['u.id', 'u.email'])
            ->andWhere('u.email = :email')
            ->andWhere('u.password = :password')
            ->setParameter('email', $email)
            ->setParameter('password', $password)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function transform(User $user)
    {
        return [
            'id'    => (int) $user->getId(),
            'email' => (string) $user->getEmail(),
            'password' => (string) $user->getPassword()
        ];
    }

    public function transformAll()
    {
        $users = $this->findAll();
        $usersArray = [];

        foreach ($users as $user) {
            $usersArray[] = $this->transform($user);
        }

        return $usersArray;
    }
}
