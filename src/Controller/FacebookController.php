<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 9/04/18
 * Time: 14:24
 */

namespace App\Controller;


use KnpU\OAuth2ClientBundle\Security\Exception\IdentityProviderAuthenticationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FacebookController extends Controller
{

    /**
     * @Route("/connect/facebook")
     */
    public function connectAction()
    {
        return $this->get('oauth2.registry')
            ->getClient('facebook_main')
            ->redirect();
    }


    public function connectCheckAction(Request $request)
    {

        $client = $this->get('oauth2.registry')
            ->getClient('facebook_main');

        try {
            $user = $client->fetchUser();

            $user->getFirstName();
        } catch (IdentityProviderAuthenticationException $e) {
            var_dump($e->getMessage());
            die;
        }

    }
}