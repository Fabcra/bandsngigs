<?php

namespace App\Repository;

use App\Entity\Venue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Venue|null find($id, $lockMode = null, $lockVersion = null)
 * @method Venue|null findOneBy(array $criteria, array $orderBy = null)
 * @method Venue[]    findAll()
 * @method Venue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VenueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Venue::class);
    }

    public function findActiveVenues()
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.active = true');

        return $qb->getQuery()
            ->getResult();
    }

    public function findVenuesWithPhoto()
    {
        $qb = $this->createQueryBuilder('v')
            ->andWhere('v.active = true')
            ->leftJoin('v.photo', 'p')->addSelect('p')
            ->orderBy('v.registrationDate', 'DESC')
            ->setMaxResults(5);

        return $qb->getQuery()
            ->getResult();
    }

    public function findVenuesByUser($id)
    {
        $qb = $this->createQueryBuilder('venue');

        $qb->leftJoin('venue.managers', 'managers')
            ->andWhere('managers.id like :id')
            ->setParameter('id', $id)
            ->andWhere('venue.active = true');

        return $qb
            ->getQuery()
            ->getResult();
    }


    public function findFavoritesVenuesByUser($id)
    {

        $qb = $this->createQueryBuilder('venue')
            ->leftJoin('venue.favUsers', 'favusers')
            ->andWhere('favusers.id like :id')
            ->andWhere('venue.active = true')
            ->setParameter('id', $id);

        return $qb
            ->getQuery()
            ->getResult();
    }
}
