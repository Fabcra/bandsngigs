<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function findImagesByBand($id)
    {

        $qb = $this->createQueryBuilder('i');
        $qb->leftJoin('i.band', 'b')
            ->andWhere('b.id like :id')
            ->setParameter('id', $id);

        return $qb->getQuery()
            ->getResult();

    }

    public function findImagesByVenue($id)
    {
        $qb = $this->createQueryBuilder('i');
        $qb->leftJoin('i.venue', 'v')
            ->andWhere('v.id like :id')
            ->setParameter('id', $id);

        return $qb->getQuery()
            ->getResult();
    }
}
