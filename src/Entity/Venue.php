<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use function Symfony\Component\VarDumper\Tests\Caster\reflectionParameterFixture;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VenueRepository")
 */
class Venue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     */
    private $description;


    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Type("string")
     */
    private $streetName;

    /**
     * @Assert\Type("alnum")
     * @ORM\Column(type="string", length=5)
     */
    private $houseNb;

    /**
     *
     * @Assert\Email(message="Adresse e-mail non valide")
     * @ORM\Column(type="string", length=50)
     */
    private $mail;

    /**
     * @Assert\Url(message="Adresse Url invalide")
     * @ORM\Column(type="string", length=50)
     */
    private $website;

    /**
     * @Assert\Type("numeric", message="Veuillez n'utiliser que des chiffres")
     * @ORM\Column(type="string", length=20)
     */
    private $phone;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="venues")
     */
    private $managers;

    /**
     * @ORM\ManyToOne(targetEntity="Locality", inversedBy="venues")
     */
    private $locality;

    /**
     * @ORM\ManyToMany(targetEntity="Style", inversedBy="venues")
     */
    private $styles;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="venue")
     */
    private $gallery;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Regex("/^(http(s)?:\/\/)?((w){3}.)?youtu(be|.be)?(\.com)?\/.+\&list=.+/", message="il ne s'agit pas d'une playlist YouTube")
     *
     */
    private $videoPlaylist;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="venue")
     */
    private $events;

    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist"})
     *
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $photo;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lng;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(name="registration_date", type="datetime")
     */
    private $registrationDate;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="favVenues"))
     */
    private $favUsers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    public function __construct()
    {
        $this->managers = new ArrayCollection();
        $this->styles = new ArrayCollection();
        $this->registrationDate = new \DateTime();
        $this->favUsers = new ArrayCollection();
        $this->setActive(true);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * @param mixed $streetName
     */
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;
    }

    /**
     * @return mixed
     */
    public function getHouseNb()
    {
        return $this->houseNb;
    }

    /**
     * @param mixed $houseNb
     */
    public function setHouseNb($houseNb)
    {
        $this->houseNb = $houseNb;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getManagers()
    {
        return $this->managers;
    }

    /**
     * @param mixed $managers
     */
    public function setManagers($managers)
    {
        $this->managers[] = $managers;
    }


    /**
     * @return mixed
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * @param mixed $locality
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;
    }

    /**
     * @return mixed
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * @param mixed $styles
     */
    public function setStyles($styles)
    {
        $this->styles[] = $styles;
    }

    /**
     * @return mixed
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param mixed $gallery
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;
    }

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return mixed
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * @param mixed $registrationDate
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;
    }

    /**
     * @return mixed
     */
    public function getVideoPlaylist()
    {
        return $this->videoPlaylist;
    }

    /**
     * @param mixed $videoPlaylist
     */
    public function setVideoPlaylist($videoPlaylist)
    {
        $this->videoPlaylist = $videoPlaylist;
    }

    /**
     * @return mixed
     */
    public function getFavUsers()
    {
        return $this->favUsers;
    }

    /**
     * @param mixed $favUsers
     */
    public function setFavUsers($favUsers)
    {
        $this->favUsers[] = $favUsers;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }


}
