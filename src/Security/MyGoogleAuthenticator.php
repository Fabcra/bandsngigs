<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 13/04/18
 * Time: 15:33
 */

namespace App\Security;


use App\Entity\Image;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;

class MyGoogleAuthenticator extends SocialAuthenticator
{

    private $clientRegistry;
    private $em;
    private $router;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $em, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
    }

    public function supports(Request $request)
    {
        // continue ONLY if the URL matches the check URL
        return $request->getPathInfo() == '/connect/google/check';
    }

    public function getCredentials(Request $request)
    {
        // this method is only called if supports() returns true

        return $this->fetchAccessToken($this->getGoogleClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var GoogleUser $googleUser */
        $googleUser = $this->getGoogleClient()
            ->fetchUserFromToken($credentials);


        // Cet E-mail est-il déjà inscrit dans la base de données ?

        $email = $googleUser->getEmail();
        $user = $this->em->getRepository(User::class)
            ->findOneBy(['email' => $email]);
        if ($user) {

            return $user;
        } else {
            $user = new User();

            $user->setGoogleId($googleUser->getId());
            $user->setFirstName($googleUser->getFirstName());
            $user->setLastName($googleUser->getLastName());
            $user->setEmail($googleUser->getEmail());
            $user->setRegistrationDate(new \DateTime('now'));
            $user->setValid(true);
            $user->setRoles(['ROLE_USER']);


            $avatar = new Image();

            // récupérer l'url en taille normale
            $googleAvatar = $googleUser->getAvatar();
            $regex = '/https(.+?)\jpg/';
            preg_match($regex, $googleAvatar, $matches);

            $avatar->setUrl($matches[0]);

            $user->setAvatar($avatar);

            $this->em->persist($user);
            $this->em->flush();

            return $user;

        }
    }

    /**
     * @return \KnpU\OAuth2ClientBundle\Client\OAuth2Client|GoogleClient
     */
    private function getGoogleClient()
    {
        return $this->clientRegistry
            ->getClient('google_main');
    }


    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $url = $this->router->generate('login');

        return new RedirectResponse($url);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $url = $this->router->generate('homepage');

        return new RedirectResponse($url);
    }


    public function start(Request $request, AuthenticationException $authException = null)
    {
        $url = $this->router->generate('connect_google_check');

        return new RedirectResponse($url);
    }
}

