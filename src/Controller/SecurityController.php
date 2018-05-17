<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 6/04/18
 * Time: 13:50
 */

namespace App\Controller;


use App\Form\PwdType;
use App\Service\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

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


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/password", name="new-password")
     * @Method({"GET","POST"})
     */
    public function updatePwd(Request $request, EncoderFactoryInterface $encoderFactory)
    {
        $user = $this->getUser();
        $id = $user->getId();
        $pwd = $user->getPassword();

        $form = $this->createForm(PwdType::class, $user, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $oldPwd = $user->getOldPassword();


            if (password_verify($oldPwd, $pwd)) {
                $plainPassword = $user->getPassword();
                $encoder = $encoderFactory->getEncoder($user);
                $encoded = $encoder->encodePassword($plainPassword, '');

                $user->setPassword($encoded);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'password modifié avec succès');
                return $this->redirectToRoute('homepage');

            }

            $this->addFlash('danger', 'password incorrect');
            return $this->render('pages/security/newpassword.html.twig', [
                'pwdForm' => $form->createView(), 'id' => $id
            ]);

        }
        return $this->render('pages/security/newpassword.html.twig', [
            'pwdForm' => $form->createView(), 'id' => $id
        ]);


    }


}