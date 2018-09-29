<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TempUserRepository")
 * @UniqueEntity("mail", message="Cette adresse E-mail est déjà enregistrée")
 */
class TempUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Email(message="Adresse e-mail invalide")
     * @ORM\Column(type="string", length=100)
     */
    private $mail;

    /**
     * @Assert\Regex(pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)/",
     *     message="Le mot de passe doit obligatoirement se composer au minimum d'une minuscule,
     *              d'une majuscule, d'un chiffre et d'un caractère spécial (oui c'est pénible mais c'est comme ça)")
     * @Assert\Length(min=8, minMessage="Le mot de passe doit avoir minimum 8 caractères")
     * @ORM\Column(type="string", length=100)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $token;

    /**
     *
     * @ORM\Column(type="date", length=10)
     */
    private $registrationDate;


    public function __construct()
    {
        $this->registrationDate = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }
}
