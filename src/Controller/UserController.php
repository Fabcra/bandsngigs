<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 3/04/18
 * Time: 16:46
 */

namespace App\Controller;


use App\Entity\Band;
use App\Entity\User;
use App\Form\RemoveUserType;
use App\Form\UserType;
use App\Service\Mailer;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    /** AFFICHE LE PROFIL D'UN UTILISATEUR
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/users/{id}", name="user")
     */
    public function showUser($id)
    {

        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->findOneBy(['id' => $id]);

        $valid = $user->getValid();

        $bands = $doctrine->getRepository(Band::class)->findBandsByUser($id);


        if ($valid === true) {

            return $this->render('pages/users/user.html.twig', [
                'user' => $user, 'bands' => $bands
            ]);
        } else {
            $this->addFlash('danger', 'Cet utilisateur n\'existe pas ou n\'est plus membre du site !!! ');
            return $this->redirectToRoute('homepage');
        }
    }


    /** MODIFIER UN PROFIL UTILISATEUR
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profile", name="profile")
     * @Method({"GET", "POST"})
     */
    public function updateUser(Request $request)
    {

        $user = $this->getUser();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $id = $user->getId();

        $form = $this->createForm(UserType::class, $user, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre profil a été modifié');
        }

        return $this->render('pages/users/profile.html.twig', [
            'userForm' => $form->createView(), 'id' => $id
        ]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/user/remove", name="remove_account")
     */
    public function removeUser(Request $request, Mailer $mailer)
    {

        $user = $this->getUser();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $valid = $user->getValid();

        $id = $user->getId();

        $form = $this->createForm(RemoveUserType::class, $user, ['method' => 'POST']);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();


            $valid = $user->getValid();

            if ($valid == true) {
                $this->addFlash('success', 'Vous prenez la bonne décision');
                return $this->redirectToRoute('homepage');
            } else {


                $bands = $user->getBands();

                if ($bands) {

                    foreach ($bands as $band) {

                        $band->removeMember($user);


                        $em->persist($band);
                        $em->flush();

                    }
                }

                $venues = $user->getVenues();

                if ($venues) {

                    foreach ($venues as $venue) {

                        $venue->removeManager($user);

                        $em->persist($venue);
                        $em->flush();
                    }
                }



                $mail = $user->getEmail();
                $subject = 'Suppression de votre compte sur Bands\'n Gigs';
                $body = $this->renderView('pages/users/cancellation-mail.html.twig', array('user' => $user));

                $mailer->sendMail($mail, $subject, $body);




                return $this->redirectToRoute('logout');

            }
        }

        if ($valid === true) {

            return $this->render('pages/users/remove.html.twig', [
                'userForm' => $form->createView(), 'id' => $id
            ]);
        } else {
            $this->addFlash('danger', 'Ce compte n\'existe plus');
        }

    }

}