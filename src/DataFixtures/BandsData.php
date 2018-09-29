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
        $band1->setPhone('0000000000');
        $band1->setWebsite($faker->url);
        $band1->setRegistrationDate($faker->dateTimeThisYear());


        $band1->setMembers($this->getReference('user1'));
        $band1->setMembers($this->getReference('user2'));
        $band1->setMembers($this->getReference('user3'));

        $band1->setLogo($this->getReference('image49'));
        $band1->setLocality($this->getReference('locality' . mt_rand(1, 50)));
        $band1->setVideoPlaylist("https://www.youtube.com/watch?v=s5VQtT1t7n8&list=PLCfCU1Ok5NVvoxxSRGBXrB_FueSk4Wzdw");
        $band1->setAudioPlaylist("https://open.spotify.com/artist/6mdiAmATAx73kdxrNrnlao");

        $band1->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band1);

        $this->addReference('band1', $band1);


        $band2 = new Band();

        $band2->setName('Meshuggrah');
        $band2->setDescription($faker->realText());
        $band2->setMail($faker->email);
        $band2->setPhone('00000000');
        $band2->setWebsite($faker->url);
        $band2->setRegistrationDate($faker->dateTimeThisYear());

            $band2->setMembers($this->getReference('user4'));
            $band2->setMembers($this->getReference('user5'));
            $band2->setMembers($this->getReference('user6'));

        $band2->setLogo($this->getReference('image50'));
        $band2->setLocality($this->getReference('locality' . mt_rand(1, 50)));
        $band2->setVideoPlaylist("https://www.youtube.com/watch?v=uq2HNLTxaZc&list=PL6961E6FC457FB9E6");
        $band2->setAudioPlaylist("https://open.spotify.com/artist/3ggwAqZD3lyT2sbovlmfQY");

        $band2->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band2);

        $this->addReference('band2', $band2);


        $band3 = new Band();

        $band3->setName('Two Foot Ninja');
        $band3->setDescription($faker->realText());
        $band3->setMail($faker->email);
        $band3->setPhone('0000000000');
        $band3->setWebsite($faker->url);
        $band3->setRegistrationDate($faker->dateTimeThisYear());


            $band3->setMembers($this->getReference('user7'));
            $band3->setMembers($this->getReference('user8'));
            $band3->setMembers($this->getReference('user9'));

        $band3->setLogo($this->getReference('image51'));
        $band3->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band3->setVideoPlaylist("https://www.youtube.com/watch?v=cHQ121jygSo&list=PLM70_3BvKVmcTNXvzf4wIWCsSUyLvNjf4");
        $band3->setAudioPlaylist("https://open.spotify.com/artist/3swwiYEQQzPNGvMdEhqReR");

        $band3->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band3);

        $this->addReference('band3', $band3);

        $band4 = new Band();

        $band4->setName('Avengers Sevenfold');
        $band4->setDescription($faker->realText());
        $band4->setMail($faker->email);
        $band4->setPhone('0000000000');
        $band4->setWebsite($faker->url);
        $band4->setRegistrationDate($faker->dateTimeThisYear());

            $band4->setMembers($this->getReference('user10'));
            $band4->setMembers($this->getReference('user11'));
            $band4->setMembers($this->getReference('user12'));

        $band4->setLogo($this->getReference('image52'));
        $band4->setLocality($this->getReference('locality' . mt_rand(1, 50)));
        $band4->setVideoPlaylist("https://www.youtube.com/watch?v=fBYVlFXsEME&list=PLpSW6gVRk77HTMSQX7Q9hsAn2IV-3s4kz");
        $band4->setAudioPlaylist("https://open.spotify.com/artist/0nmQIMXWTXfhgOBdNzhGOs");

        $band4->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band4);

        $this->addReference('band4', $band4);


        $band5 = new Band();

        $band5->setName('Cheetah');
        $band5->setDescription($faker->realText());
        $band5->setMail($faker->email);
        $band5->setPhone('0000000000');
        $band5->setWebsite($faker->url);
        $band5->setRegistrationDate($faker->dateTimeThisYear());

            $band5->setMembers($this->getReference('user13'));
            $band5->setMembers($this->getReference('user14'));
            $band5->setMembers($this->getReference('user15'));

        $band5->setLogo($this->getReference('image53'));
        $band5->setLocality($this->getReference('locality' . mt_rand(1, 50)));
        $band5->setVideoPlaylist("https://www.youtube.com/watch?v=yeVJguP_T40&list=PLxYReOMcJaFfGz1daUgyTUh9SerOLl3Vz");
        $band5->setAudioPlaylist("https://open.spotify.com/artist/14pVkFUHDL207LzLHtSA18");

        $band5->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band5);

        $this->addReference('band5', $band5);


        $band6 = new Band();

        $band6->setName('Drumtheater');
        $band6->setDescription($faker->realText());
        $band6->setMail($faker->email);
        $band6->setPhone('0000000000');
        $band6->setWebsite($faker->url);
        $band6->setRegistrationDate($faker->dateTimeThisYear());

            $band6->setMembers($this->getReference('user16'));
            $band6->setMembers($this->getReference('user17'));
            $band6->setMembers($this->getReference('user18'));

        $band6->setLogo($this->getReference('image54'));
        $band6->setLocality($this->getReference('locality' . mt_rand(1, 50)));
        $band6->setVideoPlaylist("https://www.youtube.com/watch?v=JnLdx2FyNqg&list=PLToa5JuFMsXTNkrLJbRlB--76IAOjRM9b");
        $band6->setAudioPlaylist("https://open.spotify.com/artist/2aaLAng2L2aWD2FClzwiep");

        $band6->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band6);

        $this->addReference('band6', $band6);


        $band7 = new Band();

        $band7->setName('Symfony X');
        $band7->setDescription($faker->realText());
        $band7->setMail($faker->email);
        $band7->setPhone('0000000000');
        $band7->setWebsite($faker->url);
        $band7->setRegistrationDate($faker->dateTimeThisYear());

            $band7->setMembers($this->getReference('user19'));
            $band7->setMembers($this->getReference('user20'));
            $band7->setMembers($this->getReference('user21'));

        $band7->setLogo($this->getReference('image55'));
        $band7->setLocality($this->getReference('locality' . mt_rand(1, 50)));
        $band7->setVideoPlaylist("https://www.youtube.com/watch?v=sxZQ4UEdM9c&list=PLDA921F8DC808918B");
        $band7->setAudioPlaylist("https://open.spotify.com/artist/4MnZkh4dpNmTMPxkl4Ev5L");

        $band7->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band7);

        $this->addReference('band7', $band7);


        $band8 = new Band();

        $band8->setName('Nicaragua');
        $band8->setDescription($faker->realText());
        $band8->setMail($faker->email);
        $band8->setPhone('0000000000');
        $band8->setWebsite($faker->url);
        $band8->setRegistrationDate($faker->dateTimeThisYear());
        $band8->setVideoPlaylist("https://www.youtube.com/watch?v=h2JgqF384cU&list=PLphGROqmao1IO8VDsvYeC6eM48e-MSgSx");
        $band8->setAudioPlaylist("https://open.spotify.com/artist/6olE6TJLqED3rqDCT0FyPh");

            $band8->setMembers($this->getReference('user22'));
            $band8->setMembers($this->getReference('user23'));
            $band8->setMembers($this->getReference('user24'));

        $band8->setLogo($this->getReference('image56'));
        $band8->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band8->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band8);

        $this->addReference('band8', $band8);


        $band9 = new Band();

        $band9->setName('Godsmash');
        $band9->setDescription($faker->realText());
        $band9->setMail($faker->email);
        $band9->setPhone('0000000000');
        $band9->setWebsite($faker->url);
        $band9->setRegistrationDate($faker->dateTimeThisYear());
        $band9->setVideoPlaylist("https://www.youtube.com/watch?v=pVohVy8d0s0&list=PL99O_K7Ai5RzxWcdLGWZZ4m8ulyF6wczQ");
        $band9->setAudioPlaylist("https://open.spotify.com/artist/6gZq1Q6bdOxsUPUG1TaFbF");

            $band9->setMembers($this->getReference('user25'));
            $band9->setMembers($this->getReference('user26'));
            $band9->setMembers($this->getReference('user27'));

        $band9->setLogo($this->getReference('image57'));
        $band9->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band9->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band9);

        $this->addReference('band9', $band9);


        $band10 = new Band();

        $band10->setName('Corn');
        $band10->setDescription($faker->realText());
        $band10->setMail($faker->email);
        $band10->setPhone('0000000000');
        $band10->setWebsite($faker->url);
        $band10->setRegistrationDate($faker->dateTimeThisYear());
        $band10->setVideoPlaylist("https://www.youtube.com/watch?v=cl2D7J_FL_U&list=PLImEsAJ7sjmBySHJjeA_8iLabmlEK8z4W");
        $band10->setAudioPlaylist("https://open.spotify.com/artist/3RNrq3jvMZxD9ZyoOZbQOD");

            $band10->setMembers($this->getReference('user28'));
            $band10->setMembers($this->getReference('user29'));
            $band10->setMembers($this->getReference('user30'));

        $band10->setLogo($this->getReference('image58'));
        $band10->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band10->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band10);

        $this->addReference('band10', $band10);


        $band11 = new Band();

        $band11->setName('Pink Flood');
        $band11->setDescription($faker->realText());
        $band11->setMail($faker->email);
        $band11->setPhone('0000000000');
        $band11->setWebsite($faker->url);
        $band11->setRegistrationDate($faker->dateTimeThisYear());
        $band11->setVideoPlaylist("https://www.youtube.com/watch?v=iLFwTqdsuxw&list=PLlAIujS66Q6CdVGg7lwFZuc0VG2VVMDJz");
        $band11->setAudioPlaylist("https://open.spotify.com/artist/0k17h0D3J5VfsdmQ1iZtE9");

            $band11->setMembers($this->getReference('user31'));
            $band11->setMembers($this->getReference('user32'));
            $band11->setMembers($this->getReference('user33'));

        $band11->setLogo($this->getReference('image59'));
        $band11->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band11->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band11);

        $this->addReference('band11', $band11);


        $band12 = new Band();

        $band12->setName('Guns n\' Prosit');
        $band12->setDescription($faker->realText());
        $band12->setMail($faker->email);
        $band12->setPhone('0000000000');
        $band12->setWebsite($faker->url);
        $band12->setRegistrationDate($faker->dateTimeThisYear());
        $band12->setVideoPlaylist("https://www.youtube.com/watch?v=8SbUC-UaAxE&list=PL2wCCiky2eR3Roemc3ZjWsVCUZM47Gp3_");
        $band12->setAudioPlaylist("https://open.spotify.com/artist/3qm84nBOXUEQ2vnTfUTTFC");

            $band12->setMembers($this->getReference('user34'));
            $band12->setMembers($this->getReference('user35'));
            $band12->setMembers($this->getReference('user36'));

        $band12->setLogo($this->getReference('image60'));
        $band12->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band12->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band12);

        $this->addReference('band12', $band12);


        $band13 = new Band();

        $band13->setName('AB CD');
        $band13->setDescription($faker->realText());
        $band13->setMail($faker->email);
        $band13->setPhone('0000000000');
        $band13->setWebsite($faker->url);
        $band13->setRegistrationDate($faker->dateTimeThisYear());
        $band13->setVideoPlaylist("https://www.youtube.com/watch?v=jQBLGxabQ2Q&list=PLx1MDbsLNfVQfLBqmbxjsYJG3j_B3TkCp");
        $band13->setAudioPlaylist("https://open.spotify.com/artist/711MCceyCBcFnzjGY4Q7Un");

            $band13->setMembers($this->getReference('user37'));
            $band13->setMembers($this->getReference('user38'));
            $band13->setMembers($this->getReference('user39'));

        $band13->setLogo($this->getReference('image61'));
        $band13->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band13->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band13);

        $this->addReference('band13', $band13);


        $band14 = new Band();

        $band14->setName('Metallicats');
        $band14->setDescription($faker->realText());
        $band14->setMail($faker->email);
        $band14->setPhone('0000000000');
        $band14->setWebsite($faker->url);
        $band14->setRegistrationDate($faker->dateTimeThisYear());
        $band14->setVideoPlaylist("https://www.youtube.com/watch?v=uhBHL3v4d3I&list=PLJvQXRgtxlumAHceNRk3cx3P7MZVUCdBl");
        $band14->setAudioPlaylist("https://open.spotify.com/artist/2ye2Wgw4gimLv2eAKyk1NB");

            $band14->setMembers($this->getReference('user40'));
            $band14->setMembers($this->getReference('user41'));
            $band14->setMembers($this->getReference('user42'));

        $band14->setLogo($this->getReference('image62'));
        $band14->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band14->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band14);

        $this->addReference('band14', $band14);


        $band15 = new Band();

        $band15->setName('Dismounted');
        $band15->setDescription($faker->realText());
        $band15->setMail($faker->email);
        $band15->setPhone('0000000000');
        $band15->setWebsite($faker->url);
        $band15->setRegistrationDate($faker->dateTimeThisYear());
        $band15->setVideoPlaylist("https://www.youtube.com/watch?v=ayV1MQUIHPY&list=PLif2iIyBTjSJmUOLMZj2tqOtGMwHWqUL6");
        $band15->setAudioPlaylist("https://open.spotify.com/artist/3TOqt5oJwL9BE2NG9MEwDa");

            $band15->setMembers($this->getReference('user43'));
            $band15->setMembers($this->getReference('user44'));
            $band15->setMembers($this->getReference('user45'));

        $band15->setLogo($this->getReference('image63'));
        $band15->setLocality($this->getReference('locality' . mt_rand(1, 50)));

        $band15->setStyles($this->getReference('style' . mt_rand(1, 6)));

        $manager->persist($band15);

        $this->addReference('band15', $band15);


        $band16 = new Band();

        $band16->setName('System of a Dad');
        $band16->setDescription($faker->realText());
        $band16->setMail($faker->email);
        $band16->setPhone('0000000000');
        $band16->setWebsite($faker->url);
        $band16->setRegistrationDate($faker->dateTimeThisYear());
        $band16->setVideoPlaylist("https://www.youtube.com/watch?v=zUzd9KyIDrM&list=PLcRCYbVrSCinAvcPOXDFVY4ovGVXs82AL");
        $band16->setAudioPlaylist("https://open.spotify.com/artist/5eAWCfyUhZtHHtBdNk56l1");

            $band16->setMembers($this->getReference('user46'));
            $band16->setMembers($this->getReference('user47'));
            $band16->setMembers($this->getReference('user48'));

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