<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 29/03/18
 * Time: 15:25
 */

namespace App\Controller;


use App\Entity\Event;
use App\Form\EventType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{


    public function newAction(Request $request, FileUploader $fileUploader)
    {
        $event = new Event();

        $user = $this->getUser();

        $form = $this->createForm(EventType::class, $event, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }
        return $this->render("pages/events/new.html.twig", [
            'eventForm' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/events", name="events")
     */
    public function listAction(Request $request)
    {

        $doctrine = $this->getDoctrine();

        $events = $doctrine->getRepository(Event::class)->findAll();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $events,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)
        );

        return $this->render('pages/events/events.html.twig', [
            'events' => $pagination
        ]);

    }

    /**
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/events/{slug}", name="event")
     */
    public function showAction($slug)
    {

        $doctrine = $this->getDoctrine();

        $event = $doctrine->getRepository(Event::class)->findOneBy(['slug' => $slug]);

        return $this->render('pages/events/event.html.twig', [
            'event' => $event
        ]);
    }
}