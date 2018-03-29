<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 13/03/18
 * Time: 11:47
 */

namespace App\DataFixtures;


use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ImageData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_BE');

        for ($i = 1; $i < 20; $i++) {


            $image = new Image();

            $image->setUrl($faker->imageUrl(640,480,'nightlife'));



            $manager->persist($image);

            $this->addReference('image' . $i, $image);

        }
        $manager->flush();
    }




}