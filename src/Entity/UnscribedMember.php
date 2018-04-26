<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=50)
     */
    private $nickName;



    /**
     * @ORM\ManyToMany(targetEntity="Instrument")
     */
    private $instruments;

    /**
     * @ORM\ManyToOne(targetEntity="Band", inversedBy="unscribedMembers")
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



}
