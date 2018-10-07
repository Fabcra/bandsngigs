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
            ->andWhere('e.active = true')
            ->leftJoin('e.bands', 'b')->addSelect('b')
            ->leftJoin('e.venue', 'v')->addSelect('v')
            ->leftJoin('v.locality', 'l')->addSelect('l')
            ->innerJoin('e.styles', 's')->addSelect('s');

        if ($params['by_band'] != null) {
            $qb->andWhere('b.name LIKE :band')
                ->andWhere('b.active = true')
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

    public function findNextEvents()
    {

        $qb = $this->createQueryBuilder('e')
            ->andWhere('e.date >= CURRENT_DATE()');


        return $qb->getQuery()
            ->getResult();
    }


    public function findActiveEvents()
    {

        $qb = $this->createQueryBuilder('e')
            ->andWhere('e.active = true')
            ->andWhere('e.date >= CURRENT_DATE()');


        return $qb->getQuery()
            ->getResult();
    }


    public function findEventsWithFlyer()
    {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.flyer', 'f')->addSelect('f')
            ->andWhere('e.active = true')
            ->andWhere('e.date >= CURRENT_DATE()');


        return $qb->getQuery()
            ->getResult();
    }


    public function findEventsByUser($id)
    {
        $qb = $this->createQueryBuilder('event')
            ->leftJoin('event.organiser', 'organiser')
            ->andWhere('organiser.id like :id')
            ->setParameter('id', $id)
            ->andWhere('event.active = true');

        return $qb
            ->getQuery()
            ->getResult();
    }


    public function findFavEvents($id)
    {

        $qb = $this->createQueryBuilder('event')
            ->leftJoin('event.favUsers', 'favUsers')
            ->andWhere('favUsers.id like :id')
            ->setParameter('id', $id)
            ->andWhere('event.date >= CURRENT_DATE()');

        return $qb
            ->getQuery()
            ->getResult();

    }

    public function findEventsByFavBands($id, $band_id)
    {

        $qb = $this->createQueryBuilder('event')
            ->andWhere('event.active = true')
            ->leftJoin('event.bands', 'bands')
            ->andWhere('bands.id like :band_id')
            ->setParameter('band_id', $band_id)
            ->leftJoin('bands.favUsers', 'favusers')
            ->andWhere('favusers.id like :id')
            ->setParameter('id', $id);


        return $qb
            ->getQuery()
            ->getResult();
    }

    public function findEventsByFavVenues($id, $venue_id)
    {
        $qb = $this->createQueryBuilder('event')
            ->andWhere('event.active = true')
            ->leftJoin('event.venue', 'venue')
            ->andWhere('venue.id like :venue_id')
            ->setParameter('venue_id', $venue_id)
            ->leftJoin('venue.favUsers', 'favusers')
            ->andWhere('favusers.id like :id')
            ->setParameter('id', $id)
            ->andWhere('event.date >= CURRENT_DATE()');


        return $qb
            ->getQuery()
            ->getResult();
    }


    public function findEventsByBand($id)
    {

        $qb = $this->createQueryBuilder('event')
            ->leftJoin('event.bands', 'b')
            ->leftJoin('event.venue', 'v')
            ->andWhere('b.id like :id')
            ->setParameter('id', $id)
            ->andWhere('b.active = true')
            ->andWhere('v.active = true')
            ->andWhere('event.date >= CURRENT_DATE()');

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function findEventsByVenue($id)
    {

        $qb = $this->createQueryBuilder('event')
            ->leftJoin('event.bands', 'b')
            ->leftJoin('event.venue', 'v')
            ->andWhere('v.id like :id')
            ->setParameter('id', $id)
            ->andWhere('event.active = true')
            ->andWhere('b.active = true')
            ->andWhere('v.active = true')
            ->andWhere('event.date >= CURRENT_DATE()');

        return $qb
            ->getQuery()
            ->getResult();
    }




}
