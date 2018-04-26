<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 13/03/18
 * Time: 10:29
 */

namespace App\DataFixtures;


use App\Entity\Style;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StyleData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $style1 = new Style();

        $style1->setStyle('rock');
        $manager->persist($style1);

        $this->addReference('style1', $style1);

        $style2 = new Style();

        $style2->setStyle('metal');
        $manager->persist($style2);

        $this->addReference('style2', $style2);


        $style3 = new Style();

        $style3->setStyle('jazz');
        $manager->persist($style3);

        $this->addReference('style3', $style3);

        $style4 = new Style();

        $style4->setStyle('blues');
        $manager->persist($style4);

        $this->addReference('style4', $style4);

        $style5 = new Style();

        $style5->setStyle('alternative');
        $manager->persist($style5);

        $this->addReference('style5', $style5);



        $style6 = new Style();

        $style6->setStyle('fusion');
        $manager->persist($style6);

        $this->addReference('style6', $style6);

        $manager->flush();
    }




}