<?php

namespace App\Repository;

use App\Entity\UnsubscribedVenue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UnsubscribedVenue|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnsubscribedVenue|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnsubscribedVenue[]    findAll()
 * @method UnsubscribedVenue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnsubscribedVenueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UnsubscribedVenue::class);
    }

//    /**
//     * @return UnsubscribedVenue[] Returns an array of UnsubscribedVenue objects
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
    public function findOneBySomeField($value): ?UnsubscribedVenue
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
