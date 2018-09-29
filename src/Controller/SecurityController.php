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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class SecurityController extends Controller
{
    /** AUTHENTIFICATION
     *
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


    /** MODIFICATION MOT DE PASSE
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/password", name="password-update")
     * @Security("is_granted('ROLE_USER')")
     * @Method({"GET","POST"})
     */
    public function updatePwd(Request $request, EncoderFactoryInterface $encoderFactory, Mailer $mailer)
    {
        $user = $this->getUser();
        $pwd = $user->getPassword();

        $form = $this->createForm(PwdType::class,['method'=>'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $oldPwd = $request->request->get('pwd');
            $oldPwd = $oldPwd['oldPassword'];

            $newPwd= $request->request->get('pwd');
            $newPwd= $newPwd['password']['first'];



            //vérification de l'ancien mot de passe
            if (password_verify($oldPwd, $pwd)) {
                // cryptage du nouveau mot de passe
                $plainPassword = $newPwd;
                $encoder = $encoderFactory->getEncoder($user);
                $encoded = $encoder->encodePassword($plainPassword, '');

                $user->setPassword($encoded);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                //envoi du mail
                $mail = $user->getEmail();
                $subject = "Changement du mot de passe";
                $body = $this->renderView('pages/security/modif-pwd-mail.html.twig', array('user'=>$user));


                $mailer->sendMail($mail, $subject, $body);

                $this->addFlash('success', 'password modifié avec succès');
                return $this->redirectToRoute('homepage');

                //todo: envoyer un mail de confirmation

            }

            // si l'ancien mot de passe est incorrect
            $this->addFlash('danger', 'password incorrect');
            return $this->render('pages/security/newpassword.html.twig', [
                'pwdForm' => $form->createView()
            ]);

            //todo: envoyer un mail d'avertissement
        }
        return $this->render('pages/security/newpassword.html.twig', [
            'pwdForm' => $form->createView()
        ]);


    }


}