<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 13/03/18
 * Time: 14:35
 */

namespace App\DataFixtures;


use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EventData extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_BE');

        for ($i = 1; $i < 11; $i++) {

            $u = range(1, 19);
            $b = range(1, 10);
            shuffle($u);
            shuffle($b);

            $v = mt_rand(1, 10);//une venue au hasard
            $s = mt_rand(1, 6); //un style au hasard
            $w = mt_rand(1, 19);

            $event = new Event();

            $event->setName($faker->word . "-LIVE SHOW");
            $event->setDescription($faker->text());
            $event->setDate($faker->dateTimeBetween('now', $endDate = '+ 30 days'));
            $event->setTime($faker->dateTime());
            $event->setPrice('5');
            $event->setOrganiser($this->getReference('user' . $w));

            for ($j = 1; $j < 4; $j++) {
                $event->setUsers($this->getReference('user' . $u[$j]));
                $event->setBands($this->getReference('band' . $b[$j]));
            }
            $event->setTypeVenue('1');
            $event->setVenue($this->getReference('venue' . $v));
            $event->setStyles($this->getReference('style' . $s));
            $x = $i + 64;
            $event->setFlyer($this->getReference('image' . $x));


            $manager->persist($event);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserData::class,
            BandsData::class,
            VenueData::class,
        );
    }

}