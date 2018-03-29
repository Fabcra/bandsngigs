<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserData extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_BE');




        for ($i = 1; $i < 20; $i++) {
            $j = mt_rand(1, 6);
            $x = mt_rand(1,49);
            $user1 = new User();

            $user1->setFirstName($faker->firstName());
            $user1->setLastName($faker->lastName);
            $user1->setAge(mt_rand(20, 60));
            $user1->setGender($faker->title());
            $user1->setMail($faker->email);
            $user1->setPhone($faker->phoneNumber);

            $user1->setInstruments($this->getReference('instru' . $j));
            $user1->setStyles($this->getReference('style' . $j));
            $user1->setLocality($this->getReference('locality'. $x));
            $user1->setAvatar($this->getReference('image'. $i));



            $user1->setPassword('password');
            $user1->setValid(true);
            $manager->persist($user1);

            $this->addReference('user'.$i, $user1);
        }


        $manager->flush();


    }

    public function getDependencies()
    {
        return array(
            InstrumentData::class,
            StyleData::class,
            LocalityData::class,
            ImageData::class,
        );
    }


}