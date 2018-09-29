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


        $image1 = new Image();

        $image1->setUrl('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRA4HPPHzW_5__gwxCOd7Ud_JuvmIgEqYaNpOoGTExJ_kBQcipP');

        $manager->persist($image1);

        $this->addReference('image1', $image1);

        $image2 = new Image();

        $image2->setUrl('http://www.metaltalk.net/images9/nicko.jpg');

        $manager->persist($image2);

        $this->addReference('image2', $image2);

        $image3 = new Image();

        $image3->setUrl('http://www.sounds-finder.com/wp-content/uploads/2017/09/Dave_murray.jpg');

        $manager->persist($image3);

        $this->addReference('image3', $image3);

        $image4 = new Image();

        $image4->setUrl('https://e.snmc.io/lk/f/s/ad132ca4fff97adeb2b2e7e0717ef7b7/5242526.jpg');

        $manager->persist($image4);

        $this->addReference('image4', $image4);

        $image5 = new Image();

        $image5->setUrl('https://i.pinimg.com/originals/a7/98/a9/a798a957cd57525f557abb141f98e9a7.jpg');

        $manager->persist($image5);

        $this->addReference('image5', $image5);

        $image6 = new Image();

        $image6->setUrl('http://bravewords.com/medias-static/images/news/2016/57ED34BD-meshuggah-post-final-video-trailer-for-the-violent-sleep-of-reason-we-wanted-to-take-a-step-back-to-how-we-were-doing-things-in-the-early-90s-image.jpg');

        $manager->persist($image6);

        $this->addReference('image6', $image6);

        $image7 = new Image();

        $image7->setUrl('http://loudwire.com/files/2014/05/Twelve-Foot-Ninja-3.jpg');

        $manager->persist($image7);

        $this->addReference('image7', $image7);


        $image8 = new Image();

        $image8->setUrl('http://blog.afflictionclothing.com/wp-content/uploads/2014/06/IMG_1601.jpg');

        $manager->persist($image8);

        $this->addReference('image8', $image8);


        $image9 = new Image();

        $image9->setUrl('https://pm1.narvii.com/6526/28bd2cac3f2a6cb3921e982684951c234a453f5f_hq.jpg');

        $manager->persist($image9);

        $this->addReference('image9', $image9);


        $image10 = new Image();

        $image10->setUrl('https://upload.wikimedia.org/wikipedia/commons/thumb/d/de/Avenged-Sevenfold-BergenCalling-2011-Christian_Misje-5510.jpg/220px-Avenged-Sevenfold-BergenCalling-2011-Christian_Misje-5510.jpg');

        $manager->persist($image10);

        $this->addReference('image10', $image10);


        $image11 = new Image();

        $image11->setUrl('http://www.avengedsevenfold.ru/wp-content/uploads/2013/07/A2530058.jpg');

        $manager->persist($image11);

        $this->addReference('image11', $image11);


        $image12 = new Image();

        $image12->setUrl('https://i.axs.com/2017/01/23248-9-optimized_5885113ea1c98.jpg?1522368000030');

        $manager->persist($image12);

        $this->addReference('image12', $image12);


        $image13 = new Image();

        $image13->setUrl('http://vicfirth.com/wp-content/uploads/2014/09/vinniepaul.jpg');

        $manager->persist($image13);

        $this->addReference('image13', $image13);


        $image14 = new Image();

        $image14->setUrl('https://www.billboard.com/files/styles/article_main_image/public/media/Phil-Anselmo-2015-billboard-650.jpg');

        $manager->persist($image14);

        $this->addReference('image14', $image14);


        $image15 = new Image();

        $image15->setUrl('http://matthellwing.com/wp-content/uploads/2014/12/dimebag_img3.jpg');

        $manager->persist($image15);

        $this->addReference('image15', $image15);


        $image16 = new Image();

        $image16->setUrl('http://www.albumrock.net/dyn_img/actualites/10444.jpg');

        $manager->persist($image16);

        $this->addReference('image16', $image16);


        $image17 = new Image();

        $image17->setUrl('http://www.progarchives.com/progressive_rock_discography_band/1615.jpg');

        $manager->persist($image17);

        $this->addReference('image17', $image17);


        $image18 = new Image();

        $image18->setUrl('https://vignette.wikia.nocookie.net/dreamtheater/images/7/73/B1lt7erWniS._SL600_.jpg/revision/latest?cb=20100609234110');

        $manager->persist($image18);

        $this->addReference('image18', $image18);


        $image19 = new Image();

        $image19->setUrl('https://www.rock-progresivo.com/wp-content/uploads/2017/05/Russel-Allen.jpg');

        $manager->persist($image19);

        $this->addReference('image19', $image19);


        $image20 = new Image();

        $image20->setUrl('https://orig00.deviantart.net/e28c/f/2012/056/2/9/michael_romeo___symphony_x_by_sicmentale-d4qx086.jpg');

        $manager->persist($image20);

        $this->addReference('image20', $image20);


        $image21 = new Image();

        $image21->setUrl('http://www.heavyblogisheavy.com/wp-content/uploads/2013/03/p17keudu2uoqe1brr2qo1gsi1fhk4.jpg');

        $manager->persist($image21);

        $this->addReference('image21', $image21);

        $image22 = new Image();

        $image22->setUrl('https://voi.img.pmdstatic.net/fit/http.3A.2F.2Fprd2-bone-image.2Es3-website-eu-west-1.2Eamazonaws.2Ecom.2Fprismamedia_people.2F2017.2F06.2F30.2F683534ce-ee04-49be-9da3-345d92dc0639.2Ejpeg/380x380/quality/80/kurt-cobain.jpg');

        $manager->persist($image22);

        $this->addReference('image22', $image22);


        $image23 = new Image();

        $image23->setUrl('http://nysmusic.com/wp-content/uploads/2013/10/grohl.jpg');

        $manager->persist($image23);

        $this->addReference('image23', $image23);

        $image24 = new Image();

        $image24->setUrl('https://i.skyrock.net/6577/80596577/pics/3047038339_1_11_LZ664iTv.jpg');

        $manager->persist($image24);

        $this->addReference('image24', $image24);

        $image25 = new Image();

        $image25->setUrl('https://i.pinimg.com/originals/39/a1/7d/39a17db2cf4e32c458e56ee40c7d1aad.jpg');

        $manager->persist($image25);

        $this->addReference('image25', $image25);


        $image26 = new Image();

        $image26->setUrl('https://i.pinimg.com/originals/bb/99/95/bb999544f151ca482f006aa97ecdf60f.jpg');

        $manager->persist($image26);

        $this->addReference('image26', $image26);


        $image27 = new Image();

        $image27->setUrl('http://www.dccustomguitars.com/images/tony_rombola_godsmack_dc_custom_guitars_endorsee.jpg');

        $manager->persist($image27);

        $this->addReference('image27', $image27);


        $image28 = new Image();

        $image28->setUrl('https://fanoegerm.files.wordpress.com/2012/02/392653_260488950673507_100001372110261_684916_1693984659_n.jpg');

        $manager->persist($image28);

        $this->addReference('image28', $image28);


        $image29 = new Image();

        $image29->setUrl('https://www.1057thepoint.com/sites/g/files/exi661/f/styles/large_730/public/article-images-featured/775406-344526.jpg?itok=Wm6xNvNo');

        $manager->persist($image29);

        $this->addReference('image29', $image29);


        $image30 = new Image();

        $image30->setUrl('https://i.pinimg.com/originals/1f/31/c9/1f31c9ac6c05598a5c3bf3ad7866adc9.jpg');

        $manager->persist($image30);

        $this->addReference('image30', $image30);


        $image31 = new Image();

        $image31->setUrl('https://i.pinimg.com/originals/a1/2d/58/a12d58b7f12a6ff320ad1fe733409e98.jpg');

        $manager->persist($image31);

        $this->addReference('image31', $image31);


        $image32 = new Image();

        $image32->setUrl('https://i.pinimg.com/originals/bc/7d/2f/bc7d2ffd1dbba3815e292f76ba1e3368.jpg');

        $manager->persist($image32);

        $this->addReference('image32', $image32);


        $image33 = new Image();

        $image33->setUrl('http://ksassets.timeincuk.net/wp/uploads/sites/55/2012/12/nickmason_pinkfloyd_paph_L230909-1.jpg');

        $manager->persist($image33);

        $this->addReference('image33', $image33);


        $image34 = new Image();

        $image34->setUrl('http://cdn.shopify.com/s/files/1/0775/8201/products/tumblr_n2u98eTPPJ1sgk6qro1_500_grande.jpg?v=1498839955');

        $manager->persist($image34);

        $this->addReference('image34', $image34);


        $image35 = new Image();

        $image35->setUrl('https://statics.digitick.com/commun/upload/staticUpload/musicStory/b3/c0/2_3131_0.jpg');

        $manager->persist($image35);

        $this->addReference('image35', $image35);


        $image36 = new Image();

        $image36->setUrl('https://i.pinimg.com/originals/d0/67/b5/d067b5f5ea5d139fc0e34d0adcaa6f35.jpg');

        $manager->persist($image36);

        $this->addReference('image36', $image36);

        $image37 = new Image();

        $image37->setUrl('http://i.dailymail.co.uk/i/pix/2016/03/16/00/320C31EC00000578-3494168-image-m-10_1458088210441.jpg');

        $manager->persist($image37);

        $this->addReference('image37', $image37);


        $image38 = new Image();

        $image38->setUrl('http://arhiva.dalje.com/slike/slike_3/r1/g2008/m10/x188186243849542389_5.jpg');

        $manager->persist($image38);

        $this->addReference('image38', $image38);


        $image39 = new Image();

        $image39->setUrl('https://upload.wikimedia.org/wikipedia/commons/thumb/6/60/Cliffwilliams.jpg/220px-Cliffwilliams.jpg');

        $manager->persist($image39);

        $this->addReference('image39', $image39);


        $image40 = new Image();

        $image40->setUrl('http://www2.pictures.zimbio.com/gi/James+Hetfield+SiriusXM+Presents+Metallica+2rKgqnDXi-yl.jpg');

        $manager->persist($image40);

        $this->addReference('image40', $image40);


        $image41 = new Image();

        $image41->setUrl('https://media.gettyimages.com/photos/metallicas-lars-ulrich-attends-92nd-street-y-presents-metallicas-lars-picture-id870683898?k=6&m=870683898&s=594x594&w=0&h=_aktQUD9YKgKKEFaUZByo0nT-_7vo-jzg1DrClRZJBE=');

        $manager->persist($image41);

        $this->addReference('image41', $image41);


        $image42 = new Image();

        $image42->setUrl('http://images6.fanpop.com/image/photos/32400000/Kirk-kirk-hammett-32483957-331-500.jpg');

        $manager->persist($image42);

        $this->addReference('image42', $image42);


        $image43 = new Image();

        $image43->setUrl('http://i.imgur.com/4Rx9VqV.jpg');

        $manager->persist($image43);

        $this->addReference('image43', $image43);


        $image44 = new Image();

        $image44->setUrl('https://live-imagecollect.s3.amazonaws.com/preview/136/fcaa1c7f9fb0242');

        $manager->persist($image44);

        $this->addReference('image44', $image44);


        $image45 = new Image();

        $image45->setUrl('http://assets.blabbermouth.net/media/moyerschool.jpg');

        $manager->persist($image45);

        $this->addReference('image45', $image45);

        $image46 = new Image();

        $image46->setUrl('https://i.pinimg.com/originals/c0/7c/47/c07c47010296e7def6971e7959ece341.jpg');

        $manager->persist($image46);

        $this->addReference('image46', $image46);


        $image47 = new Image();

        $image47->setUrl('https://i.pinimg.com/originals/db/8a/b2/db8ab2bebb8c7214bb0b9da034162871.jpg');

        $manager->persist($image47);

        $this->addReference('image47', $image47);


        $image48 = new Image();

        $image48->setUrl('http://www.matt-thornton.net/images/topics/11/johndolmayan.jpg');

        $manager->persist($image48);

        $this->addReference('image48', $image48);


        $image49 = new Image();

        $image49->setUrl('https://images4.alphacoders.com/105/10546.jpg');

        $manager->persist($image49);

        $this->addReference('image49', $image49);


        $image50 = new Image();

        $image50->setUrl('https://img3.goodfon.com/wallpaper/big/e/e8/meshuggah-metal-extreme-metal.jpg');

        $manager->persist($image50);

        $this->addReference('image50', $image50);

        $image51 = new Image();

        $image51->setUrl('http://www.bringthenoiseuk.com/wordpress/wp-content/uploads/Twelve-Foot-Ninja-2016.jpg');

        $manager->persist($image51);

        $this->addReference('image51', $image51);

        $image52 = new Image();

        $image52->setUrl('https://cdnrockol-rockolcomsrl.netdna-ssl.com/HY4tlt8pLBSi9OkJcbELJuJi7Ec=/640x480/smart/rockol-img/img/foto/upload/avengedsevenfold.JPG');

        $manager->persist($image52);

        $this->addReference('image52', $image52);

        $image53 = new Image();

        $image53->setUrl('https://i.pinimg.com/736x/17/15/9c/17159cf823fada3294a2ee4b3b6de556--band-of-brothers-music.jpg');

        $manager->persist($image53);

        $this->addReference('image53', $image53);

        $image54 = new Image();

        $image54->setUrl('http://media.interaksyon.com/wp-content/uploads/2017/09/dream-theater-640x480.jpg');

        $manager->persist($image54);

        $this->addReference('image54', $image54);

        $image55 = new Image();

        $image55->setUrl('http://fc04.deviantart.net/fs51/f/2009/301/b/9/Symphony_X_masks_by_Soi_of_the_shadow.jpg');

        $manager->persist($image55);

        $this->addReference('image55', $image55);

        $image56 = new Image();

        $image56->setUrl('https://media3.s-nbcnews.com/j/streams/2013/December/131217/2D10150571-ss-110916-nevermind-nirvana-tease.today-inline-large.jpg');

        $manager->persist($image56);

        $this->addReference('image56', $image56);

        $image57 = new Image();

        $image57->setUrl('http://images.motorcycle-usa.com/photogallerys/Godsmack-Boston-2015.jpg');

        $manager->persist($image57);

        $this->addReference('image57', $image57);

        $image58 = new Image();

        $image58->setUrl('http://www.pakshowbiz.com/wp-content/uploads/2017/04/1381450-korn-1491981991-715-640x480.jpeg');

        $manager->persist($image58);

        $this->addReference('image58', $image58);

        $image59 = new Image();

        $image59->setUrl('https://c.tribune.com.pk/2017/03/1361255-pinkfloyd-1490077185-305-640x480.jpg');

        $manager->persist($image59);

        $this->addReference('image59', $image59);


        $image60 = new Image();

        $image60->setUrl('https://959online.com/wp-content/uploads/2016/04/guns-n-roses-640x480.jpg');

        $manager->persist($image60);

        $this->addReference('image60', $image60);

        $image61 = new Image();

        $image61->setUrl('http://s1.1zoom.me/b5050/10/316580-alexfas01_640x480.jpg');

        $manager->persist($image61);

        $this->addReference('image61', $image61);
        $image62 = new Image();

        $image62->setUrl('https://media.livenationinternational.com/lincsmedia/Media/p/a/v/48cb820f-9c7a-e147-a533-759d56d1f77a.jpg');

        $manager->persist($image62);

        $this->addReference('image62', $image62);

        $image63 = new Image();

        $image63->setUrl('http://wallpaperesque.com/wp-content/uploads/plixpapers1503/disturbed_wallpaper_background_36187-640x480.jpg');

        $manager->persist($image63);

        $this->addReference('image63', $image63);

        $image64 = new Image();

        $image64->setUrl('https://i1.wp.com/www.ferroproductions.com/wp-content/uploads/2012/09/system-of-a-down1.jpg?resize=640%2C480');

        $manager->persist($image64);

        $this->addReference('image64', $image64);


        for ($i = 65; $i < 81; $i++) {


            $image = new Image();
            $image->setUrl($faker->imageUrl(640,480,'nightlife'));
           // $image->setUrl('https://media.timeout.com/images/100017737/image.jpg');
            $manager->persist($image);
            $this->addReference('image' . $i, $image);

        }


        $manager->flush();
    }


}