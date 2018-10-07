<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email", message="Un compte existe déjà avec cette adresse")
 *
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $googleId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bannedgoogle;


    /**
     * @Assert\Type("string")
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @Assert\Type("string")
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;


    private $fullName;


    /**
     *
     * @ORM\Column(type="integer", nullable=true, length=3)
     * @Assert\Range(min=10, max="100", minMessage="Veuillez indiquer un âge supérieur à 10 ans", maxMessage="Impressionnant, mais je vous vois plus jeune")
     *
     */
    private $age;

    /**
     * @ORM\Column(type="string", nullable=true, length=7)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", unique=true, length=150)
     * @Assert\Email(message="E-mail non valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true, length=15)
     * @Assert\Regex(pattern="/^[0-9]*$/", message="indiquez uniquement des nombres (sans espace, ni tiret, ni parenthèse)")
     *
     */
    private $phone;

    /**
     * @Assert\Regex(pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)/",
     *     message="Le mot de passe doit obligatoirement se composer au minimum d'une minuscule,
     *              d'une majuscule, d'un chiffre et d'un caractère spécial (oui c'est pénible mais c'est comme ça)")
     * @Assert\Length(min=8, minMessage="Le mot de passe doit avoir minimum 8 caractères")
     *
     * @ORM\Column(type="string", length=240, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(name="old_pwd", nullable=true))
     */
    private $oldPassword;


    /**
     * @ORM\Column(type="boolean")
     */
    private $valid;

    /**
     * @ORM\ManyToMany(targetEntity="Instrument", inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private $instruments;

    /**
     * @ORM\ManyToMany(targetEntity="Style", inversedBy="users")
     *
     */
    private $styles;

    /**
     * @ORM\ManyToOne(targetEntity="Locality", inversedBy="users")
     */
    private $locality;

    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $avatar;

    /**
     * @ORM\ManyToMany(targetEntity="Band", mappedBy="members")
     */
    private $bands;

    /**
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="users")
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity="Venue", mappedBy="managers")
     */
    private $venues;

    /**
     * @Gedmo\Slug(fields={"email"})
     * @ORM\Column(length=50, unique=true)
     */
    private $slug;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;


    /**
     * @ORM\Column(type="date")
     */
    private $registrationDate;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="organiser")
     */
    private $shows;


    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\IsTrue()
     */
    private $confidentiality;

    /**
     * @ORM\ManyToMany(targetEntity="Band", inversedBy="favUsers")
     */
    private $favBands;

    /**
     * @ORM\ManyToMany(targetEntity="Venue", inversedBy="favUsers")
     */
    private $favVenues;

    /**
     * @ORM\ManyToMany(targetEntity="Event", inversedBy="favUsers")
     */
    private $favEvents;

    /**
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="spectator")
     */
    private $tickets;

    public function __construct()
    {
        $this->instruments = new ArrayCollection();
        $this->styles = new ArrayCollection();
        $this->favBands= new ArrayCollection();
        $this->favVenues = new ArrayCollection();
        $this->favEvents = new ArrayCollection();
        $this->bannedgoogle = false;
    }

    public function getRoles()
    {
        $roles = $this->roles;

        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }
    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }


    public function getUsername()
    {
        return $this->email;
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
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * @param mixed $googleId
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
    }


    /**
     *
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }


    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function getInstruments()
    {
        return $this->instruments;
    }

    /**
     * @param mixed $instruments
     */
    public function setInstruments($instruments)
    {
        $this->instruments[] = $instruments;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * @param mixed $valid
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
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
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
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
        $this->bands = $bands;
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
    public function getShows()
    {
        return $this->shows;
    }

    /**
     * @param mixed $shows
     */
    public function setShows($shows)
    {
        $this->shows = $shows;
    }


    /**
     * @return mixed
     */
    public function getVenues()
    {
        return $this->venues;
    }

    /**
     * @param mixed $venues
     */
    public function setVenues($venues)
    {
        $this->venues = $venues;
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
    public function getDescription()
    {
        return $this->description;
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
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getSalt()
    {
        return null;
    }


    public function eraseCredentials()
    {
        return null;
    }



    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            ) = unserialize($serialized);
    }


    /**
     * @return mixed
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param mixed $oldPassword
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
    }


    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->getFullName();

    }

    /**
     * @return mixed
     */
    public function getConfidentiality()
    {
        return $this->confidentiality;
    }

    /**
     * @param mixed $confidentiality
     */
    public function setConfidentiality($confidentiality)
    {
        $this->confidentiality = $confidentiality;
    }

    /**
     * @return mixed
     */
    public function getFavBands()
    {
        return $this->favBands;
    }

    /**
     * @param mixed $favBands
     */
    public function setFavBands($favBands)
    {
        $this->favBands[] = $favBands;
    }

    public function addFavBand(Band $band){
        $this->favBands[]=$band;
    }

    public function removeFavBand(Band $band){

        $this->favBands->removeElement($band);
    }

    /**
     * @return mixed
     */
    public function getFavVenues()
    {
        return $this->favVenues;
    }

    /**
     * @param mixed $favVenues
     */
    public function setFavVenues($favVenues)
    {
        $this->favVenues = $favVenues;
    }

    public function addFavVenue(Venue $venue){
        $this->favVenues[]=$venue;
    }

    public function removeFavVenue(Venue $venue){

        $this->favVenues->removeElement($venue);
    }

    /**
     * @return mixed
     */
    public function getFavEvents()
    {
        return $this->favEvents;
    }

    /**
     * @param mixed $favEvents
     */
    public function setFavEvents($favEvents)
    {
        $this->favEvents = $favEvents;
    }

    public function addFavEvent(Event $event){

        $this->favEvents[]= $event;
    }

    public function removeFavEvent(Event $event){

        $this->favEvents->removeElement($event);

    }

    /**
     * @return mixed
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * @param mixed $tickets
     */
    public function setTickets($tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * @return mixed
     */
    public function getBannedgoogle()
    {
        return $this->bannedgoogle;
    }

    /**
     * @param mixed $bannedgoogle
     */
    public function setBannedgoogle($bannedgoogle)
    {
        $this->bannedgoogle = $bannedgoogle;
    }




}
