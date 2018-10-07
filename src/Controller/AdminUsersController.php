<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 3/10/18
 * Time: 18:49
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\RemoveUserType;
use App\Form\RolesType;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class AdminUsersController
 * @package App\Controller
 * @Security("is_granted('ROLE_ADMIN')")
 */
class AdminUsersController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin", name="admin")
     */
    public function adminManageUsers(Request $request)
    {

        $doctrine = $this->getDoctrine();


        $users = $doctrine->getRepository(User::class)->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render('pages/admin/users/users.html.twig', [
            'users' => $pagination
        ]);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/users/profile/{id}", name="admin-users-profile")
     */
    public function adminModifUser(Request $request, $id)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->findOneById($id);


        $form = $this->createForm(UserType::class, $user, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Vous avez modifié le profil de ' . $user->getFirstName() . ' ' . $user->getLastName());
        }

        return $this->render('pages/admin/users/profile.html.twig', [
            'userForm' => $form->createView(), 'id' => $id
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("admin/users/ban/{id}", name="admin-user-ban")
     *
     */
    public function adminBanUser(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->findOneById($id);

        $google_user = $user->getGoogleId();



        $form = $this->createForm(RemoveUserType::class, $user, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($google_user){


                $user->setBannedgoogle(true);

            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $valid = $user->getValid();


            if ($valid === false) {

                $this->addFlash('success', 'Vous avez banni ' . $user->getFirstName() . ' ' . $user->getLastName(). 'et cette sentence est irrévocable ! ');
            }
        }

        return $this->render('pages/admin/users/ban-profile.html.twig', [
            'userForm' => $form->createView(), 'id' => $id, 'user'=>$user
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/roles/{id}", name="admin-roles")
     */
    public function adminRoleUsers(Request $request, $id)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->findOneById($id);

        $form = $this->createForm(RolesType::class, $user, ['method' => 'POST']);

        $form->handleRequest($request);

        $confidentiality = $user->getConfidentiality();


        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);

            $em->flush();

            $roles = $user->getRoles();

            if (in_array('ROLE_ADMIN', $roles)) {


                $this->addFlash('success', 'vous avez défini ' . $user->getfirstName() . ' en tant qu\' administrateur');
            }

        }


        if ($confidentiality === true) {

            return $this->render('pages/admin/users/roles.html.twig', [
                'roleForm' => $form->createView(), 'id' => $id, 'user' => $user
            ]);

        } else {
            $this->addFlash('danger', 'Cet utilisateur ne peut être administrateur
            sans accepter les règles de confidentialités du site');

            return $this->redirectToRoute('admin');
        }
    }

}