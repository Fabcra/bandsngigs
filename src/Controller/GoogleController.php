<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 13/04/18
 * Time: 10:36
 */

// CONNEXION VIA GOOGLE CONNECT

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GoogleController extends Controller
{

    /**
     * @Route("/connect/google", name="connect_google")
     */
    public function connectAction()
    {

        return $this->get('oauth2.registry')
            ->getClient('google_main')
            ->redirect();
    }


    /**
     * @param Request $request
     *
     * @Route("/connect/google/check", name="connect_google_check")
     */
    public function connectCheckAction(Request $request)
    {
    }

}