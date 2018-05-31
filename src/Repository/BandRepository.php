<?php

namespace App\Repository;

use App\Entity\Band;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Band|null find($id, $lockMode = null, $lockVersion = null)
 * @method Band|null findOneBy(array $criteria, array $orderBy = null)
 * @method Band[]    findAll()
 * @method Band[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BandRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Band::class);
    }

    public function findBandsByUser($id)
    {

        $qb = $this->createQueryBuilder('band');

        $qb->leftJoin('band.users', 'users')
            ->andWhere('users.id like :id')
            ->setParameter('id', $id);

        return $qb
            ->getQuery()
            ->getResult();

    }


}
