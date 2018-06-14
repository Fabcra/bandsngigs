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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{


    /** CREER UN NOUVEL EVENEMENT
     *
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("events/new", name="event-new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request, FileUploader $fileUploader)
    {
        $event = new Event();

        $user = $this->getUser();

        $form = $this->createForm(EventType::class, $event, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // upload d'un flyers
            $img = $event->getFlyer();
            $file = $img->getFile();
            $fileName = $fileUploader->upload($file);

            $img->setUrl('/uploads/img/' . $fileName);

            $em = $this->getDoctrine()->getManager();

            $event->setUsers($user);

            $em->persist($event);

            $em->flush();

            $this->addFlash('success', "Vous avez créé l'évènement " . $event->getName());

            return $this->redirectToRoute('homepage');
        }
        return $this->render("pages/events/new.html.twig", [
            'eventForm' => $form->createView()
        ]);
    }

    /** LISTER LES EVENEMENTS
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/events", name="events")
     */
    public function listAction(Request $request)
    {

        $doctrine = $this->getDoctrine();

        $events = $doctrine->getRepository(Event::class)->findAll();

        //pagination
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
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("events/update/{id}", name="events-update")
     */
    public function updateEvent(Request $request, FileUploader $fileUploader, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $doctrine = $this->getDoctrine();
        $event = $doctrine->getRepository(Event::class)->findOneById($id);

        $organiser_id = $event->getOrganiser()->getId();
        $user_id = $this->getUser()->getId();

        $form = $this->createForm(EventType::class, $event, ['method' => 'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Modification effectuée avec succès');
        }

        if ($user_id === $organiser_id) {
            return $this->render('pages/events/update.html.twig', [
                'eventForm' => $form->createView(), 'id' => $id, 'event' => $event
            ]);
        } else {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cet élément');
            return $this->redirectToRoute('homepage');
        }

    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/events/manage", name="events-manager")
     */
    public function manageEvents(Request $request)
    {
        $user = $this->getUser();
        $id = $user->getId();
        $doctrine = $this->getDoctrine();
        $events = $doctrine->getRepository(Event::class)->findEventsByUser($id);

        //pagination
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $events,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)
        );


        return $this->render('pages/events/manage.html.twig', [
            'events' => $pagination
        ]);
    }


    /** AFFICHER LA PAGE D'UN EVENEMENT
     *
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