<?php

namespace App\DataFixtures;


use App\Entity\Instrument;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class InstrumentData extends Fixture
{

    public function load(ObjectManager $manager)
    {


        $instrument1 = new Instrument();

        $instrument1->setName('guitare');
        $manager->persist($instrument1);

        $this->addReference('instru1', $instrument1);


        $instrument2 = new Instrument();

        $instrument2->setName('basse');
        $manager->persist($instrument2);

        $this->addReference('instru2', $instrument2);


        $instrument3 = new Instrument();

        $instrument3->setName('batterie');
        $manager->persist($instrument3);

        $this->addReference('instru3', $instrument3);


        $instrument4 = new Instrument();

        $instrument4->setName('clavier');
        $manager->persist($instrument4);

        $this->addReference('instru4', $instrument4);


        $instrument5 = new Instrument();

        $instrument5->setName('chant');
        $manager->persist($instrument5);

        $this->addReference('instru5', $instrument5);


        $instrument6 = new Instrument();

        $instrument6->setName('saxophone');
        $manager->persist($instrument6);

        $this->addReference('instru6', $instrument6);

        $manager->flush();


    }




}