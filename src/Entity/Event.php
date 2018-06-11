<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="date", length=20)
     */
    private $date;

    /**
     * @ORM\Column(type="time", length=20)
     */
    private $time;

    /**
     * @ORM\Column(type="integer", length=4)
     */
    private $price;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="events" )
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="Band", inversedBy="events")
     */
    private $bands;

    /**
     * @ORM\ManyToOne(targetEntity="Venue", inversedBy="events")
     * @ORM\JoinColumn(nullable=true)
     */
    private $venue;

    /**
     * @ORM\ManyToMany(targetEntity="Style", inversedBy="events")
     */
    private $styles;

    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist"})
     */
    private $flyer;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=50, unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="UnsubscribedBand", mappedBy="event", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $unsubscribedBands;

    /**
     * @ORM\OneToOne(targetEntity="UnsubscribedVenue", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $unsubscribedVenue;

    /**
     * @ORM\Column(name="registration_date", type="datetime")
     */
    private $registrationDate;

    public function __construct()
    {
        $this->styles = new ArrayCollection();
        $this->bands = new ArrayCollection();
        $this->unsubscribedBands = new ArrayCollection();
        $this->registrationDate = new \DateTime();

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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
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
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users[] = $users;
    }

    /**
     * @return mixed
     */
    public function getBands()
    {
        return $this->bands;
    }

    /**
     * @param mixed $bands
     */
    public function setBands($bands)
    {
        $this->bands[] = $bands;
    }

    /**
     * @return mixed
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * @param mixed $venue
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
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
    public function getFlyer()
    {
        return $this->flyer;
    }

    /**
     * @param mixed $flyer
     */
    public function setFlyer($flyer)
    {
        $this->flyer = $flyer;
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

    /**
     * @return mixed
     */
    public function getUnsubscribedBands()
    {
        return $this->unsubscribedBands;
    }

    /**
     * @param mixed $unsubscribedBands
     */
    public function setUnsubscribedBands($unsubscribedBands)
    {
        $this->unsubscribedBands = $unsubscribedBands;
    }

    /**
     * @param UnsubscribedBand $unsubscribedBand
     * @return ArrayCollection
     */
    public function addUnsubscribedBand(UnsubscribedBand $unsubscribedBand)
    {

        if(! $this->unsubscribedBands->contains($unsubscribedBand)){
            $unsubscribedBand->setEvent($this);
            $this->unsubscribedBands->add($unsubscribedBand);
        }

        return $this->unsubscribedBands;

    }

    /**
     * @param UnsubscribedBand $unsubscribedBand
     * @return mixed
     */
    public function removeUnsubscribedBand(UnsubscribedBand $unsubscribedBand)
    {
        if($this->unsubscribedBands->contains($unsubscribedBand)){
            $this->unsubscribedBands->removeElement($unsubscribedBand);
        }
        return $this->getName();
    }


    /**
     * @return mixed
     */
    public function getUnsubscribedVenue()
    {
        return $this->unsubscribedVenue;
    }

    /**
     * @param mixed $unsubscribedVenue
     */
    public function setUnsubscribedVenue($unsubscribedVenue)
    {
        $this->unsubscribedVenue = $unsubscribedVenue;
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







}
