<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 3/04/18
 * Time: 16:46
 */

namespace App\Controller;


use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/users/{id}", name="user")
     */
    public function showAction($id){

        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->findOneBy(['id'=>$id]);

        return $this->render('pages/users/user.html.twig', [
           'user'=>$user
        ]);
    }

}