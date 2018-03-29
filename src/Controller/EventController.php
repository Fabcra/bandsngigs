<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 29/03/18
 * Time: 15:25
 */

namespace App\Controller;



use App\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
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
}