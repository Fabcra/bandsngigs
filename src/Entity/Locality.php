<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocalityRepository")
 */
class Locality
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="locality", length=30)
     * @Assert\NotBlank(groups={"default, unsubscribed"}, message="cette valeur ne peut être vide")
     */
    private $locality;

    /**
     * @ORM\ManyToOne(targetEntity="PostCode")
     */
    private $postCode;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="locality")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="Venue", mappedBy="locality")
     */
    private $venues;


    /**
     * @ORM\OneToMany(targetEntity="UnsubscribedVenue", mappedBy="locality")
     */
    private $unsubscribedVenues;

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
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * @param mixed $postCode
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
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
    public function getUnsubscribedVenues()
    {
        return $this->unsubscribedVenues;
    }

    /**
     * @param mixed $unsubscribedVenues
     */
    public function setUnsubscribedVenues($unsubscribedVenues)
    {
        $this->unsubscribedVenues = $unsubscribedVenues;
    }




    public function __toString()
    {
        return $this->getLocality();
    }


}
