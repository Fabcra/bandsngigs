<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 13/03/18
 * Time: 15:15
 */

namespace App\DataFixtures;


use App\Entity\Venue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class VenueData extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_BE');

        for ($i = 1; $i < 15; $i++) {

            $n = range(1, 19);
            shuffle($n);

            $l = mt_rand(1, 49);
            $s = mt_rand(1, 6);

            $lat1 = mt_rand(50, 51);
            $latlng2 = mt_rand(111111, 999999);

            $lng1 = mt_rand(3, 5);


            $venue = new Venue();

            $venue->setName($faker->company);
            $venue->setDescription($faker->text());
            $venue->setStreetName($faker->streetName);
            $venue->setHouseNb(mt_rand(1, 99));
            $venue->setPhone($faker->phoneNumber);
            $venue->setMail($faker->companyEmail);
            $venue->setLat($lat1 . '.' . $latlng2);
            $venue->setLng($lng1 . '.' . $latlng2);
            $venue->setWebsite('http://www.' . $faker->word . '.com');
            $venue->setRegistrationDate($faker->dateTimeThisYear());


            for ($j = 1; $j < 3; $j++) {
                $venue->setMembers($this->getReference('user' . $n[$j]));
            }
            $venue->setLocality($this->getReference('locality' . $l));
            $venue->setStyles($this->getReference('style' . $s));

            $x = $i + 64;
            $venue->setPhoto($this->getReference('image' . $x));


            $manager->persist($venue);

            $this->addReference('venue' . $i, $venue);
        }
        


        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserData::class,
            StyleData::class,
        );
    }


}