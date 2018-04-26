<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 17/04/18
 * Time: 13:36
 */

namespace App\Controller;


use App\Entity\TempUser;
use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ConfirmationController extends Controller
{


    /**
     * @param Request $request
     * @param $token
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/confirmation/{id}/{token}", name="confirmation")
     */
    public function confirmation(Request $request, $token, $id)
    {

        $doctrine = $this->getDoctrine();
        $tempuser = $doctrine->getRepository(TempUser::class)->findOneBy(['id'=>$id]);


        if($token === $tempuser->getToken()){

            $mail=$tempuser->getMail();
            $registrationDate=$tempuser->getRegistrationDate();
            $password = $tempuser->getPassword();

            $user = new User();
            $user->setMail($mail);
            $user->setRegistrationDate($registrationDate);
            $user->setPassword($password);


            $form = $this->createForm(UserType::class, $user, ['method'=>'POST']);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){

                $em = $this->getDoctrine()->getManager();

                $user->setValid(true);

                $em->remove($tempuser);
                $em->persist($user);

                $em->flush();

                //log in après inscription
                $mytoken = new UsernamePasswordToken(
                    $user,
                    $password,
                    'main',
                    $user->getRoles()
                );

                $this->get('security.token_storage')->setToken($mytoken);
                $this->get('session')->set('_security_main', serialize($mytoken));


                $this->addFlash('success', 'Votre profil est confirmé');

                return $this->redirectToRoute('homepage');

            }

            return $this->render('pages/registration/confirmation.html.twig', [
                'userForm'=>$form->createView()
            ]);

        }


    }


}