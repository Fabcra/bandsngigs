<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tickets")
     */
    private $spectator;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="tickets")
     */
    private $event;

    /**
     * @ORM\Column(type="integer")
     */
    private $purchasedTicketsNb;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="string")
     */
    private $ticketPdf;

    /**
     * @ORM\Column(type="string")
     */
    private $verificationNb;

    /**
     * @return mixed
     */
    public function getSpectator()
    {
        return $this->spectator;
    }

    /**
     * @param mixed $spectator
     */
    public function setSpectator($spectator)
    {
        $this->spectator = $spectator;
    }


    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return mixed
     */
    public function getPurchasedTicketsNb()
    {
        return $this->purchasedTicketsNb;
    }

    /**
     * @param mixed $purchasedTicketsNb
     */
    public function setPurchasedTicketsNb($purchasedTicketsNb)
    {
        $this->purchasedTicketsNb = $purchasedTicketsNb;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getTicketPdf()
    {
        return $this->ticketPdf;
    }

    /**
     * @param mixed $ticketPdf
     */
    public function setTicketPdf($ticketPdf)
    {
        $this->ticketPdf = $ticketPdf;
    }


    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getVerificationNb()
    {
        return $this->verificationNb;
    }

    /**
     * @param mixed $verificationNb
     */
    public function setVerificationNb($verificationNb)
    {
        $this->verificationNb = $verificationNb;
    }





}
