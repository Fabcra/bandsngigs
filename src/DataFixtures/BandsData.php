<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 13/03/18
 * Time: 12:06
 */

namespace App\DataFixtures;


use App\Entity\Band;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class BandsData extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_BE');

        for($i=1; $i<15; $i++){

            $n = range(1,19);
            shuffle($n);

            $x = mt_rand(1,6);

            $band = new Band();

            $band->setName($faker->word);
            $band->setDescription($faker->realText());
            $band->setMail($faker->email);
            $band->setPhone($faker->phoneNumber);
            $band->setWebsite($faker->url);

            for($j=1; $j<3; $j++){
                $band->setUsers($this->getReference('user' . $n[$j]));
            }
            $band->setLogo($this->getReference('image' .$i));
            $band->setLocality($this->getReference('locality' .$i));
            $band->setStyles($this->getReference('style' .$x));

            $manager->persist($band);

            $this->addReference('band'.$i, $band);

        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserData::class,
        );
    }


}