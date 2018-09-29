<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnsubscribedVenueRepository")
 *
 */
class UnsubscribedVenue
{
    const UNSUBSCRIBED = 2;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"unsubscribed"}, message="Cette valeur ne peut être vide")
     * @Assert\Regex(pattern="/^[a-z\-]+$/i", message="Cette valeur est incorrecte")
     *
     */
    private $name;


    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"unsubscribed"}, message="Cette valeur ne peut être vide")
     */
    private $streetName;


    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(groups={"unsubscribed"}, message="Cette valeur ne peut être vide")
     */
    private $houseNb;


    /**
     * @ORM\ManyToOne(targetEntity="Locality", inversedBy="unsubscribedVenues")
     * @Assert\NotBlank(groups={"unsubscribed"}, message="Cette valeur ne peut être vide")
     */
    private $locality;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lng;


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
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


}
