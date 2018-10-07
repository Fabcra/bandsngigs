<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 6/10/18
 * Time: 09:31
 */

namespace App\Controller;


use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminEventsController
 * @package App\Controller
 * @Security("is_granted('ROLE_ADMIN')")
 */
class AdminEventsController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/events", name="admin-events")
     */
    public function adminManageEvents(Request $request){


        $doctrine = $this->getDoctrine();

        $events = $doctrine->getRepository(Event::class)->findNextEvents();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $events,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render('pages/admin/events/events.html.twig', [
            'events' => $pagination
        ]);

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/events/update/{id}", name="admin-events-update")
     */
    public function adminUpdateEvents(Request $request, $id){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $doctrine = $this->getDoctrine();
        $repo = $doctrine->getRepository(Event::class);
        $event = $repo->findOneById($id);


        $form = $this->createForm(EventType::class, $event, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Modification effectuée avec succès');
        }


        return $this->render('pages/admin/events/update.html.twig', [
            'eventForm' => $form->createView(), 'id' => $id, 'event' => $event,
        ]);

    }


}