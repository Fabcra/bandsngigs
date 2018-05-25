<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 3/04/18
 * Time: 16:46
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
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
    public function showUser($id){

        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->findOneBy(['id'=>$id]);

        return $this->render('pages/users/user.html.twig', [
           'user'=>$user
        ]);
    }


    /** MODIFIER UN PROFIL UTILISATEUR
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/profile", name="profile")
     * @Method({"GET", "POST"})
     */
    public function updateUser(Request $request){

        $user = $this->getUser();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $id = $user->getId();

        $form = $this->createForm(UserType::class, $user, ['method'=>'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render('pages/users/profile.html.twig', [
            'userForm'=>$form->createView(), 'id'=>$id
        ]);


    }

}