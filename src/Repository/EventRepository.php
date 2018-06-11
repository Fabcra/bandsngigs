<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function search($params)
    {

        $qb = $this->createQueryBuilder('e');

        $qb
            ->leftJoin('e.bands', 'b')->addSelect('b')
            ->leftJoin('e.venue', 'v')->addSelect('v')
            ->leftJoin('v.locality', 'l')->addSelect('l')
            ->innerJoin('e.styles', 's')->addSelect('s');

        if ($params['by_band'] != null) {
            $qb->andWhere('b.name LIKE :band')
                ->setParameter('band', '%' . $params['by_band'] . '%');
        }

        if ($params['by_location'] != null) {
            $qb->andwhere('l.locality LIKE :locality')
                ->setParameter('locality', '%' . $params['by_location'] . '%');
        }

        if ($params['by_style'] != null) {

            $qb->andWhere('s.style LIKE :style')
                ->setParameter('style', '%' . $params['by_style'] . '%');

        }


        return $qb->getQuery()
            ->getResult();
    }


    public function findEventsWithFlyer()
    {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.flyer', 'f')->addSelect('f')
            ->andWhere('e.date >= CURRENT_DATE()');


        return $qb->getQuery()
            ->getResult();
    }





}
