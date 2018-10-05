<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BandRepository")
 */
class Band
{
    /**
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @Assert\Type("string")
     * @ORM\Column(length=150, type="string", unique=true)
     */
    private $name;

    /**
     * @Assert\Email(message="E-mail non valide")
     * @ORM\Column(type="string", length=150)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Le numéro de téléphone ne doit contenir que des chiffres (pas d'espace ni de tirets ni de parenthèse)")
     */
    private $phone;

    /**
     * @Assert\Url(message="Cette url n'est pas correcte")
     * @ORM\Column(type="string", length=150)
     */
    private $website;

    /**
     * @Assert\Type("string")
     * @ORM\Column(type="text", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="bands")
     */
    private $members;


    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Assert\Valid()
     */
    private $logo;

    /**
     * @ORM\OneToMany(targetEntity="Album", mappedBy="band")
     */
    private $albums;


    /**
     * @ORM\ManyToOne(targetEntity="Locality")
     */
    private $locality;

    /**
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="bands")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="band", cascade={"remove"})
     *
     */
    private $gallery;

    /**
     * @ORM\ManyToMany(targetEntity="Style", inversedBy="bands")
     * @Assert\NotBlank(message="cette valeur ne peut être vide")
     */
    private $styles;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Regex("/^(http(s)?:\/\/)?((w){3}.)?youtu(be|.be)?(\.com)?\/.+\&list=.+/", message="il ne s'agit pas d'une playlist YouTube")
     *
     */
    private $videoPlaylist;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Regex("/^http(s):\/\/open\.spotify\.com.+/", message="il ne s'agit pas d'une playlist Spotify")
     */
    private $audioPlaylist;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=50, unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="UnscribedMember", mappedBy="band", cascade={"persist"}, orphanRemoval=true      )
     */
    private $unscribedMembers;

    /**
     * @ORM\Column(name="registration_date", type="datetime")
     */
    private $registrationDate;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="favBands")
     */
    private $favUsers;

    /**
     * @ORM\Column(type="boolean", options={"default":true}))
     */
    private $active;


    public function __construct()
    {
        $this->styles = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->unscribedMembers = new ArrayCollection();
        $this->gallery = new ArrayCollection();
        $this->registrationDate = new \DateTime();
        $this->favUsers= new ArrayCollection();
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
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param mixed $members
     */
    public function setMembers($members)
    {
        $this->members[] = $members;
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
    public function getAudioPlaylist()
    {
        return $this->audioPlaylist;
    }

    /**
     * @param mixed $audioPlaylist
     */
    public function setAudioPlaylist($audioPlaylist)
    {
        $this->audioPlaylist = $audioPlaylist;
    }


    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param mixed $albums
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;
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



    /**
     * @return mixed
     */
    public function getUnscribedMembers()
    {
        return $this->unscribedMembers;
    }

    /**
     * @param $unscribedMembers
     */
    public function setUnscribedMembers($unscribedMembers)
    {
        $this->unscribedMembers = $unscribedMembers;

    }

    /**
     * @param User $member
     * @return ArrayCollection
     */
    public function removeMember(User $member){

        if ($this->members->contains($member)){
            $this->members->removeElement($member);
        }

        return $this->members;
    }


    /**
     * @param UnscribedMember $unscribedMember
     * @return ArrayCollection
     */
    public function addUnscribedMember(UnscribedMember $unscribedMember)
    {

        if (! $this->unscribedMembers->contains($unscribedMember)) {

            $unscribedMember->setBand($this);
            $this->unscribedMembers->add($unscribedMember);

        }

        return $this->unscribedMembers;
    }

    /**
     * @param UnscribedMember $unscribedMember
     * @return ArrayCollection
     */
    public function removeUnscribedMember(UnscribedMember $unscribedMember)
    {
        if ($this->unscribedMembers->contains($unscribedMember)){
        $this->unscribedMembers->removeElement($unscribedMember);
        }
        return $this->unscribedMembers;
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



    public function __toString()
    {
        return $this->getName();
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
