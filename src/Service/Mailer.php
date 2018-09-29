<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 8/04/18
 * Time: 13:37
 */

namespace App\Service;


class Mailer
{

    private $mailer;


    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }


    public function sendMail($mail, $subject, $body)
    {

        $message =(new \Swift_Message($subject))
            ->setFrom("administration@bandsngigs.com")
            ->setTo($mail)
            ->setBody($body)
            ->setContentType("text/html")
        ;

        return $this->mailer->send($message);

    }


}