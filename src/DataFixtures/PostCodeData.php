<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 13/03/18
 * Time: 15:43
 */

namespace App\DataFixtures;


use App\Entity\PostCode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PostCodeData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_BE');

        for($i=1; $i<50 ; $i++){

            $postcode = new PostCode();

            $postcode->setPostCode($faker->postcode);
            $manager->persist($postcode);

            $this->addReference('postcode'.$i, $postcode);
        }
        $manager->flush();
    }




}