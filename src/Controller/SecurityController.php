<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 6/04/18
 * Time: 13:50
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');


        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('pages/security/login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error' => $error,
            ));
    }

}