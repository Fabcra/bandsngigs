<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 29/03/18
 * Time: 15:25
 */

namespace App\Controller;


use App\Entity\Band;
use App\Entity\Event;
use App\Entity\Locality;
use App\Entity\Venue;
use App\Form\EventType;
use App\Form\RemoveEventType;
use App\Service\FileUploader;
use App\Service\Mailer;
use App\Service\MapLocation;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\Annotation as Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
    public function newAction(Request $request, FileUploader $fileUploader, MapLocation $mapLocation)
    {
        $event = new Event();

        $user = $this->getUser();

        $form = $this->createForm(EventType::class, $event, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $event->setActive(true);

            // upload d'un flyers
            $img = $event->getFlyer();
            $file = $img->getFile();
            $fileName = $fileUploader->upload($file);

            $img->setUrl('/uploads/img/' . $fileName);

            $em = $this->getDoctrine()->getManager();

            $event->setUsers($user);
            $event->setOrganiser($user);


            $venue = $event->getUnsubscribedVenue();


            // si encodage d'un lieu de concert non-inscrit
            if ($venue != null) {

                $myaddress = $request->request->get('event');

                $streetname = $myaddress['unsubscribedVenue']['streetName'];
                $housenb = $myaddress['unsubscribedVenue']['houseNb'];
                $locality = $myaddress['unsubscribedVenue']['locality'];


                $localityname = $this->getDoctrine()->getRepository(Locality::class)->findOneById($locality);

                $fulladdress = $streetname . "+" . $housenb . "+" . $localityname;
                $address = str_replace(" ", "+", $fulladdress);

                $res = $mapLocation->getPosition($address);

                $lat = $res->geometry->location->lat;
                $lng = $res->geometry->location->lng;

                $venue->setLat($lat);
                $venue->setLng($lng);
            }

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

        $events = $doctrine->getRepository(Event::class)->findActiveEvents();

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


    /** API REST - récupérer les évènements d'un groupe ou café-concert
     *
     *
     * @Rest\Get(
     *     path="/api/events/{slug}",
     *     name="list-events",
     *     )
     *
     * @Rest\View()
     */
    public function getevents($slug)
    {

        $doctrine = $this->getDoctrine();

        $band = $doctrine->getRepository(Band::class)->findOneBy(['slug' => $slug]);

        if ($band == null) {
            $venue = $doctrine->getRepository(Venue::class)->findOneBy(['slug' => $slug]);

            $venue_id = $venue->getId();

            $events = $doctrine->getRepository(Event::class)->findEventsByVenue($venue_id);

        } else {

            $band_id = $band->getId();

            $events = $doctrine->getRepository(Event::class)->findEventsByBand($band_id);
        }

        $eventbyx = [];

        foreach ($events as $event) {

            $venue = $event->getVenue();


            $eventbyx[] = [
                'name' => $event->getName(),
                'date' => $event->getDate(),
                'time' => $event->getTime(),
                'description' => $event->getDescription(),
                'price' => $event->getPrice(),
                'venue' => $venue->getName(),
                'streetname' => $venue->getStreetName(),
                'housenb' => $venue->getHouseNb(),
                'locality' => $venue->getLocality()->getLocality()

            ];
        }

        return $eventbyx;

    }


    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("events/update/{id}", name="events-update")
     * @Method({"GET","POST"})
     */
    public function updateEvent(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $doctrine = $this->getDoctrine();
        $event = $doctrine->getRepository(Event::class)->findOneById($id);

        $active = $event->getActive();

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

        if ($active === true) {

            if ($user_id === $organiser_id) {
                return $this->render('pages/events/update.html.twig', [
                    'eventForm' => $form->createView(), 'id' => $id, 'event' => $event
                ]);
            } else {
                $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cet élément');
                return $this->redirectToRoute('homepage');
            }
        } else {

            return $this->redirectToRoute('homepage');
        }
    }


    /** LISTER LES EVENEMENTS ORGANISES PAR L'UTILISATEUR CONNECTE
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/events/manage", name="events-manage")
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

    /** affiche la liste des évènements favoris
     * @return Response
     * @Route("/events/favorites", name="favorites-events")
     */
    public function favoritesEvents(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $user = $this->getUser();


        if ($user) {
            $user_id = $user->getId();
            $events = $doctrine->getRepository(Event::class)->findFavEvents($user_id);

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $events,
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 3)
            );
        }

        return $this->render('pages/events/favorites.html.twig', [
            'events' => $pagination, 'favorites' => $events, 'venues' => null

        ]);

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/events/remove/{id}", name="events-remove")
     */
    public function removeEvent(Request $request, $id, Mailer $mailer)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $doctrine = $this->getDoctrine();
        $event = $doctrine->getRepository(Event::class)->findOneById($id);
        $active = $event->getActive();
        $organiser_id = $event->getOrganiser()->getId();
        $user_id = $this->getUser()->getId();

        $form = $this->createForm(RemoveEventType::class, $event, ['method' => 'POST']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($event);
            $em->flush();

            $active = $event->getActive();

            if ($active === false) {
                $this->addFlash('success', 'Vous avez supprimé l\'évènement ' . $event->getName());


                //envoyer mail

                // je récupére le tableau des tickets vendus pour l'évènement
                $tickets = $event->getTickets();

                foreach ($tickets as $ticket) {

                    //je récupère les adresses e-mails des spectateurs qui ont achetés un ticket en ligne

                    $spectator = $ticket->getSpectator();
                    $mail = $spectator->getEmail();
                    $subject = 'Concert annulé !!! ';
                    $body = $this->renderView(
                        'pages/events/cancellation_mail.html.twig', array('event' => $event, 'spectator' => $spectator));

                    $mailer->sendMail($mail, $subject, $body);
                }
                return $this->redirectToRoute('homepage');
            }
        }

        if ($active === true) {

            if ($user_id === $organiser_id) {
                return $this->render('pages/events/remove.html.twig', [
                    'removeEventForm' => $form->createView(), 'id' => $id, 'event' => $event
                ]);
            } else {
                $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cet élément');
                return $this->redirectToRoute('homepage');
            }
        } else {
            $this->addFlash('danger', 'Cet évènement a déjà été supprimé');
            return $this->redirectToRoute('homepage');
        }

    }


    /** AFFICHER LA PAGE D'UN EVENEMENT
     *
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/events/{slug}", name="event")
     */
    public function showAction($slug)
    {
        $user = $this->getUser();


        $doctrine = $this->getDoctrine();

        $event = $doctrine->getRepository(Event::class)->findOneBy(['slug' => $slug]);

        $active = $event->getActive();


        $event_id = $event->getId();

        $venue = $event->getId();

        $events = $doctrine->getRepository(Event::class)->findEventsByVenue($venue);


        $favorite = 'unliked';

        if ($user) {

            $favevents = $user->getFavEvents();

            foreach ($favevents as $favevent) {
                $favevent_id[] = $favevent->getId();

                if (in_array($event_id, $favevent_id)) {

                    $favorite = 'liked';
                } else {
                    $favorite = 'unliked';
                }
            }
        }

        if ($active === false) {

            $this->addFlash('danger', 'Attention, cet évènement a été annulé, les places précédemment achetées seront remboursées intégralement');
        }


        return $this->render('pages/events/event.html.twig', [
            'event' => $event, 'events' => $events, 'favorite' => $favorite
        ]);
    }


    /** TEST FONCTIONNEMENT DE L'API
     *
     *
     * @param $slug
     * @Route("/testapi/{slug}", name="testapi")
     */
    public function testApi($slug)
    {

        $url = file_get_contents('https://www.fabrice-crahay.be/api/events/' . $slug);

        $response = json_decode($url, true);

        dump($response);
        die();
    }


}