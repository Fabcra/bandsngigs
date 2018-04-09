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


        $band1 = new Band();

        $band1->setName('Silver Maiden');
        $band1->setDescription($faker->realText());
        $band1->setMail($faker->email);
        $band1->setPhone($faker->phoneNumber);
        $band1->setWebsite($faker->url);


        $band1->setUsers($this->getReference('user1'));
        $band1->setUsers($this->getReference('user2'));
        $band1->setUsers($this->getReference('user3'));

        $band1->setLogo($this->getReference('image49'));
        $band1->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band1->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band1);

        $this->addReference('band1', $band1);


        $band2 = new Band();

        $band2->setName('Leshuggah');
        $band2->setDescription($faker->realText());
        $band2->setMail($faker->email);
        $band2->setPhone($faker->phoneNumber);
        $band2->setWebsite($faker->url);

            $band2->setUsers($this->getReference('user4'));
            $band2->setUsers($this->getReference('user5'));
            $band2->setUsers($this->getReference('user6'));

        $band2->setLogo($this->getReference('image50'));
        $band2->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band2->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band2);

        $this->addReference('band2', $band2);


        $band3 = new Band();

        $band3->setName('Twelve Foot Ninja');
        $band3->setDescription($faker->realText());
        $band3->setMail($faker->email);
        $band3->setPhone($faker->phoneNumber);
        $band3->setWebsite($faker->url);

            $band3->setUsers($this->getReference('user7'));
            $band3->setUsers($this->getReference('user8'));
            $band3->setUsers($this->getReference('user9'));

        $band3->setLogo($this->getReference('image51'));
        $band3->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band3->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band3);

        $this->addReference('band3', $band3);

        $band4 = new Band();

        $band4->setName('Avenged Sevenfield');
        $band4->setDescription($faker->realText());
        $band4->setMail($faker->email);
        $band4->setPhone($faker->phoneNumber);
        $band4->setWebsite($faker->url);

            $band4->setUsers($this->getReference('user10'));
            $band4->setUsers($this->getReference('user11'));
            $band4->setUsers($this->getReference('user12'));

        $band4->setLogo($this->getReference('image52'));
        $band4->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band4->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band4);

        $this->addReference('band4', $band4);


        $band5 = new Band();

        $band5->setName('Panteraï');
        $band5->setDescription($faker->realText());
        $band5->setMail($faker->email);
        $band5->setPhone($faker->phoneNumber);
        $band5->setWebsite($faker->url);

            $band5->setUsers($this->getReference('user13'));
            $band5->setUsers($this->getReference('user14'));
            $band5->setUsers($this->getReference('user15'));

        $band5->setLogo($this->getReference('image53'));
        $band5->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band5->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band5);

        $this->addReference('band5', $band5);


        $band6 = new Band();

        $band6->setName('Drumtheater');
        $band6->setDescription($faker->realText());
        $band6->setMail($faker->email);
        $band6->setPhone($faker->phoneNumber);
        $band6->setWebsite($faker->url);

            $band6->setUsers($this->getReference('user16'));
            $band6->setUsers($this->getReference('user17'));
            $band6->setUsers($this->getReference('user18'));

        $band6->setLogo($this->getReference('image54'));
        $band6->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band6->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band6);

        $this->addReference('band6', $band6);


        $band7 = new Band();

        $band7->setName('Symfony 4');
        $band7->setDescription($faker->realText());
        $band7->setMail($faker->email);
        $band7->setPhone($faker->phoneNumber);
        $band7->setWebsite($faker->url);

            $band7->setUsers($this->getReference('user19'));
            $band7->setUsers($this->getReference('user20'));
            $band7->setUsers($this->getReference('user21'));

        $band7->setLogo($this->getReference('image55'));
        $band7->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band7->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band7);

        $this->addReference('band7', $band7);


        $band8 = new Band();

        $band8->setName('Nicaragua');
        $band8->setDescription($faker->realText());
        $band8->setMail($faker->email);
        $band8->setPhone($faker->phoneNumber);
        $band8->setWebsite($faker->url);

            $band8->setUsers($this->getReference('user22'));
            $band8->setUsers($this->getReference('user23'));
            $band8->setUsers($this->getReference('user24'));

        $band8->setLogo($this->getReference('image56'));
        $band8->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band8->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band8);

        $this->addReference('band8', $band8);


        $band9 = new Band();

        $band9->setName('Godsmick');
        $band9->setDescription($faker->realText());
        $band9->setMail($faker->email);
        $band9->setPhone($faker->phoneNumber);
        $band9->setWebsite($faker->url);

            $band9->setUsers($this->getReference('user25'));
            $band9->setUsers($this->getReference('user26'));
            $band9->setUsers($this->getReference('user27'));

        $band9->setLogo($this->getReference('image57'));
        $band9->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band9->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band9);

        $this->addReference('band9', $band9);


        $band10 = new Band();

        $band10->setName('Corn');
        $band10->setDescription($faker->realText());
        $band10->setMail($faker->email);
        $band10->setPhone($faker->phoneNumber);
        $band10->setWebsite($faker->url);

            $band10->setUsers($this->getReference('user28'));
            $band10->setUsers($this->getReference('user29'));
            $band10->setUsers($this->getReference('user30'));

        $band10->setLogo($this->getReference('image58'));
        $band10->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band10->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band10);

        $this->addReference('band10', $band10);


        $band11 = new Band();

        $band11->setName('Pink Flood');
        $band11->setDescription($faker->realText());
        $band11->setMail($faker->email);
        $band11->setPhone($faker->phoneNumber);
        $band11->setWebsite($faker->url);

            $band11->setUsers($this->getReference('user31'));
            $band11->setUsers($this->getReference('user32'));
            $band11->setUsers($this->getReference('user33'));

        $band11->setLogo($this->getReference('image59'));
        $band11->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band11->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band11);

        $this->addReference('band11', $band11);


        $band12 = new Band();

        $band12->setName('Gun\'s n Flowers');
        $band12->setDescription($faker->realText());
        $band12->setMail($faker->email);
        $band12->setPhone($faker->phoneNumber);
        $band12->setWebsite($faker->url);

            $band12->setUsers($this->getReference('user34'));
            $band12->setUsers($this->getReference('user35'));
            $band12->setUsers($this->getReference('user36'));

        $band12->setLogo($this->getReference('image60'));
        $band12->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band12->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band12);

        $this->addReference('band12', $band12);


        $band13 = new Band();

        $band13->setName('AB CD');
        $band13->setDescription($faker->realText());
        $band13->setMail($faker->email);
        $band13->setPhone($faker->phoneNumber);
        $band13->setWebsite($faker->url);

            $band13->setUsers($this->getReference('user37'));
            $band13->setUsers($this->getReference('user38'));
            $band13->setUsers($this->getReference('user39'));

        $band13->setLogo($this->getReference('image61'));
        $band13->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band13->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band13);

        $this->addReference('band13', $band13);


        $band14 = new Band();

        $band14->setName('Metallicats');
        $band14->setDescription($faker->realText());
        $band14->setMail($faker->email);
        $band14->setPhone($faker->phoneNumber);
        $band14->setWebsite($faker->url);

            $band14->setUsers($this->getReference('user40'));
            $band14->setUsers($this->getReference('user41'));
            $band14->setUsers($this->getReference('user42'));

        $band14->setLogo($this->getReference('image62'));
        $band14->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band14->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band14);

        $this->addReference('band14', $band14);


        $band15 = new Band();

        $band15->setName('Disturb');
        $band15->setDescription($faker->realText());
        $band15->setMail($faker->email);
        $band15->setPhone($faker->phoneNumber);
        $band15->setWebsite($faker->url);

            $band15->setUsers($this->getReference('user43'));
            $band15->setUsers($this->getReference('user44'));
            $band15->setUsers($this->getReference('user45'));

        $band15->setLogo($this->getReference('image63'));
        $band15->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band15->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band15);

        $this->addReference('band15', $band15);


        $band16 = new Band();

        $band16->setName('System of a Dawn');
        $band16->setDescription($faker->realText());
        $band16->setMail($faker->email);
        $band16->setPhone($faker->phoneNumber);
        $band16->setWebsite($faker->url);

            $band16->setUsers($this->getReference('user46'));
            $band16->setUsers($this->getReference('user47'));
            $band16->setUsers($this->getReference('user48'));

        $band16->setLogo($this->getReference('image64'));
        $band16->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band16->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band16);

        $this->addReference('band16', $band16);


        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserData::class,
        );
    }


}