<?php

namespace App\Repository\App;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email OR u.phone = :phone')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->setParameter('phone', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
