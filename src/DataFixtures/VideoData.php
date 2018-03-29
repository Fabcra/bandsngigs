<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 13/03/18
 * Time: 16:46
 */

namespace App\DataFixtures;


use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class VideoData extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {


        for ($i = 1; $i < 10; $i++) {

            $video = new Video();

            $video->setUrl('https://youtu.be/6Xpl9R0ndiQ');
            $video->setBand($this->getReference('band' . $i));
            $video->setVenue($this->getReference('venue' . $i));

            $manager->persist($video);
        }
        $manager->flush();
    }

    function getDependencies()
    {
        return array(
            BandsData::class,
            VenueData::class,
        );
    }


}