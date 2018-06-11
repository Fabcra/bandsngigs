<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 1/06/18
 * Time: 14:42
 */

namespace App\Controller;


use App\Entity\Band;
use App\Entity\Venue;
use App\Form\ManagerType;
use App\Form\MemberType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MemberController extends Controller
{

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("bands/members/{id}", name="bands-members")
     * @Method({"GET", "POST"})
     */
    public function manageBandMembers(Request $request, $id)
    {

        $doctrine = $this->getDoctrine();
        $band = $doctrine->getRepository(Band::class)->findOneById($id);
        $user = $this->getUser();
        $user_id = $user->getId();
        $members = $band->getMembers();

        foreach ($members as $member) {
            $member_id[] = $member->getId();
        }

        $form = $this->createForm(MemberType::class, $band, ['method'=>'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($band);
            $em->flush();

            $this->addFlash('success', 'Modifications enregistrées');

        }
        if (in_array($user_id, $member_id)) {
            return $this->render('pages/bands/members.html.twig', ['memberForm' => $form->createView(), 'band' => $band, 'members' => $members, 'id' => $id]);
        }else{
            $this->addFlash('danger','Vous ne pouvez pas modifier cet élément');
            return $this->redirectToRoute('homepage');
        }

    }


    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("venues/managers/{id}", name="venues-members")
     * @Method({"GET", "POST"})
     */
    public function manageVenueMembers(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();
        $venue = $doctrine->getRepository(Venue::class)->findOneById($id);
        $user = $this->getUser();
        $user_id = $user->getId();
        $managers = $venue->getManagers();

        foreach ($managers as $manager) {
            $manager_id[] = $manager->getId();
        }

        $form = $this->createForm(ManagerType::class, $venue, ['method'=>'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($venue);
            $em->flush();

            $this->addFlash('success', 'Modifications enregistrées');

        }
        if (in_array($user_id, $manager_id)) {
            return $this->render('pages/venues/managers.html.twig', ['managerForm' => $form->createView(), 'venue' => $venue, 'managers' => $managers, 'id' => $id]);
        }else{
            $this->addFlash('danger','Vous ne pouvez pas modifier cet élément');
            return $this->redirectToRoute('homepage');
        }

    }


}