<?php

namespace App\Repository;

use App\Entity\PostCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PostCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostCode[]    findAll()
 * @method PostCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostCodeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PostCode::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
