<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 14/03/18
 * Time: 13:39
 */

namespace App\DataFixtures;


use App\Entity\Album;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AlbumData extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_EN');

        for($i = 1; $i < 10; $i++){

            $b = mt_rand(1,10);

            $album = new Album();

            $album->setTitle($faker->word);
            $album->setDescription($faker->text());
            $album->setYear($faker->dateTime());

            $album->setBand($this->getReference('band' .$b));
            $album->setCover($this->getReference('image'.$i));

            $manager->persist($album);
        }
        $manager->flush();
    }

    function getDependencies()
    {
        return array(
            BandsData::class,
            ImageData::class,
        );
    }


}