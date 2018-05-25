<?php

namespace App\Repository;

use App\Entity\UnscribedMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UnscribedMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnscribedMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnscribedMember[]    findAll()
 * @method UnscribedMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnscribedMemberRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UnscribedMember::class);
    }

//    /**
//     * @return UnscribedMember[] Returns an array of UnscribedMember objects
//     */
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
    public function findOneBySomeField($value): ?UnscribedMember
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
