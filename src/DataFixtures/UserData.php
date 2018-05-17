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




        for ($i = 1; $i < 49; $i++) {
            $j = mt_rand(1, 6);
            $x = mt_rand(1,49);
            $user1 = new User();

            $user1->setFirstName($faker->firstName('male'));
            $user1->setLastName($faker->lastName);
            $user1->setAge(mt_rand(20, 60));
            $user1->setGender($faker->title());
            $user1->setEmail($faker->email);
            $user1->setPhone('000000000000');
            $user1->setDescription($faker->text(400));

            $user1->setInstruments($this->getReference('instru' . $j));
            $user1->setStyles($this->getReference('style' . $j));
            $user1->setLocality($this->getReference('locality'. $x));
            $user1->setAvatar($this->getReference('image'. $i));
            $user1->setRegistrationDate($faker->dateTimeThisYear());
            $user1->setRoles(['ROLE_USER']);


            $user1->setPassword('$2y$10$xAHGwNsB6Pd3mM2fsIuJCeYWXMnUZU6YROLCZwtvij2XhnG/ymrYO');
            $user1->setValid(true);
            $manager->persist($user1);

            $this->addReference('user'.$i, $user1);
        }

        $j = mt_rand(1, 6);
        $x = mt_rand(1,49);
        $user2 = new User();

        $user2->setFirstName($faker->firstName('male'));
        $user2->setLastName($faker->lastName);
        $user2->setAge(mt_rand(20, 60));
        $user2->setGender($faker->title());
        $user2->setEmail("test@test.be");
        $user2->setPhone('000000000000');
        $user2->setDescription($faker->text(400));

        $user2->setInstruments($this->getReference('instru' . $j));
        $user2->setStyles($this->getReference('style' . $j));
        $user2->setLocality($this->getReference('locality'. $x));
        $user2->setAvatar($this->getReference('image'. $i));
        $user2->setRegistrationDate($faker->dateTimeThisYear());
        $user2->setRoles(['ROLE_USER']);

        $user2->setPassword('$2y$10$xAHGwNsB6Pd3mM2fsIuJCeYWXMnUZU6YROLCZwtvij2XhnG/ymrYO');
        $user2->setValid(true);
        $manager->persist($user2);

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