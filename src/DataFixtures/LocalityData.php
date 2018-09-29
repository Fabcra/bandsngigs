<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 13/03/18
 * Time: 11:04
 */

namespace App\DataFixtures;


use App\Entity\Locality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class LocalityData extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {

       $faker = Faker\Factory::create('fr_BE');


       for ($i=1; $i<51; $i++){

            $locality = new Locality();

            $locality->setLocality($faker->city);
            $locality->setPostCode($this->getReference('postcode'.$i));
            $manager->persist($locality);

            $this->addReference('locality'.$i , $locality);


        }

        $manager->flush();

    }

    public function getDependencies()
    {
       return array(
            PostCodeData::class,
        );
    }


}