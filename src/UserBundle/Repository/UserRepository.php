<?php

namespace UserBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{

    public function getUserLikes($user)
    {
        return $this->createQueryBuilder('user')
                        ->leftjoin('user.likePhotos', 'likePhoto')
                        ->addSelect('likePhoto')
                        ->where('user = :user')
                        ->setParameter('user', $user)
                        ->getQuery()
                        ->getOneOrNullResult()
        ;
    }

    public function getUserCart($user)
    {
        return $this->createQueryBuilder('user')
                        ->leftjoin('user.carts', 'cart')
                        ->addSelect('cart')
                        ->leftjoin('cart.photo', 'photo')
                        ->addSelect('photo')
                        ->where('user = :user')
                        ->setParameter('user', $user)
                        ->getQuery()
                        ->getOneOrNullResult()
        ;
    }
}