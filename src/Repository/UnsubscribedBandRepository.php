<?php

namespace App\Repository;

use App\Entity\UnsubscribedBand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UnsubscribedBand|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnsubscribedBand|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnsubscribedBand[]    findAll()
 * @method UnsubscribedBand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnsubscribedBandRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UnsubscribedBand::class);
    }

//    /**
//     * @return UnsubscribedBand[] Returns an array of UnsubscribedBand objects
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
    public function findOneBySomeField($value): ?UnsubscribedBand
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
