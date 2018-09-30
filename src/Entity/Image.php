<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @Assert\Valid()
     *
     * @ORM\Column(type="string", length=240)
     */
    protected $url;


    /**
     * @Assert\File(
     *     maxSize="2M",
     *     maxSizeMessage="La taille de l'image ne peut dépasser 2Mo",
     *     mimeTypes={"image/jpeg", "image/png"},
     *     mimeTypesMessage="Veuillez charger une image de type jpg ou png"
     * )
     *
     * @Assert\NotBlank(message="cette valeur ne peut être vide")

     */
    protected $file;

    /**
     * @ORM\ManyToOne(targetEntity="Band", inversedBy="gallery", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $band;

    /**
     * @ORM\ManyToOne(targetEntity="Venue", inversedBy="gallery")
     */
    private $venue;


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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getBand()
    {
        return $this->band;
    }

    /**
     * @param mixed $band
     */
    public function setBand($band)
    {
        $this->band = $band;
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
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    public function __toString()
    {
        return $this->url;
    }


}
