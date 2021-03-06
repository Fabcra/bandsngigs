<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnscribedMemberRepository")
 */
class UnscribedMember
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Regex(pattern="/^[a-z\-]+$/i", message="Cette valeur est incorrecte")
     * @Assert\NotBlank(message="cette valeur ne peut être vide")
     * @ORM\Column(type="string", length=50)
     */
    private $nickName;



    /**
     * @ORM\ManyToMany(targetEntity="Instrument")
     * @Assert\NotBlank(message="cette valeur ne peut être vide")
     */
    private $instruments;

    /**
     * @ORM\ManyToOne(targetEntity="Band", inversedBy="unscribedMembers", cascade={"persist"})
     * @ORM\JoinColumn(name="band_id", referencedColumnName="id", nullable=false)
     */
    private $band;


    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * @param mixed $nickName
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
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
        $this->instruments = $instruments;
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

}
