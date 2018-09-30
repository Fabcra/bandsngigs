<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 29/03/18
 * Time: 13:46
 */

namespace App\Controller;


use App\Entity\Event;
use App\Entity\Image;
use App\Entity\Locality;
use App\Entity\Venue;
use App\Form\VenueType;
use App\Service\FileUploader;
use App\Service\MapLocation;
use App\Service\YoutubeAPI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VenueController extends Controller
{

    // private static $apikey = "AIzaSyA-nXEJ0eim6B9-G3B9GQLUnLsNxrs9A7g";

    /** CREER UN NOUVEAU CAFE-CONCERT
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return string
     * @Route("venues/new", name="venue-new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request, FileUploader $fileUploader, MapLocation $mapLocation)
    {

        $venue = new Venue();


        $user = $this->getUser();

        $form = $this->createForm(VenueType::class, $venue, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $myaddress = $request->request->get('venue');

            $streetname = $myaddress['streetName'];
            $housenb = $myaddress['houseNb'];
            $locality = $myaddress['locality'];


            $localityname = $this->getDoctrine()->getRepository(Locality::class)->findOneById($locality);
            $fulladdress = $streetname . "+" . $housenb . "+" . $localityname;
            $address = str_replace(" ", "+", $fulladdress);


            /*  $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=".self::$apikey."&address=$address");

              $json = json_decode($json);


              $res = $json->results[0];*/

            $res = $mapLocation->getPosition($address);

            $lat = $res->geometry->location->lat;
            $lng = $res->geometry->location->lng;

            // upload de l'image
            $img = $venue->getPhoto();
            $file = $img->getFile();
            $fileName = $fileUploader->upload($file);

            $img->setUrl('/uploads/img/' . $fileName);

            $em = $this->getDoctrine()->getManager();

            // l'utilisateur est considéré comme gestionnaire du profil café-concert
            $venue->setManagers($user);

            $venue->setLat($lat);
            $venue->setLng($lng);

            $venue->setActive(true);

            $em->persist($venue);
            $em->flush();

            $this->addFlash('success', 'Vous avez créé la salle de spectacle ' . $venue->getName());

            return $this->redirectToRoute('homepage');

        }
        return $this->render('pages/venues/new.html.twig', [
            'venueForm' => $form->createView()
        ]);
    }

    /** LISTER LES CAFES-CONCERT
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/venues", name="venues")
     */
    public function listAction(Request $request)
    {

        $doctrine = $this->getDoctrine();

        $venues = $doctrine->getRepository(Venue::class)->findActiveVenues();

        //pagination
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $venues,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 4)
        );

        return $this->render('pages/venues/venues.html.twig', [
            'venues' => $pagination
        ]);

    }


    /**
     * AFFICHE LA LISTE DES CAFES-CONCERTS SELON
     * SI L'UTILISATEUR CONNECTE
     * EN EST ADMINISTRATEUR
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/venues/manage", name="venues-manage")
     */
    public function manageVenues(Request $request)
    {
        $user = $this->getUser();
        $id = $user->getId();
        $doctrine = $this->getDoctrine();
        $venues = $doctrine->getRepository(Venue::class)->findVenuesByUser($id);

        //pagination
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $venues,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 4)
        );

        return $this->render('pages/venues/manage.html.twig', [
            'venues' => $pagination
        ]);
    }

    /**
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("venues/update/{id}", name="venues-update")
     * @Method({"GET", "POST"})
     */
    public function updateVenue(Request $request, FileUploader $fileUploader, $id)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $doctrine = $this->getDoctrine();
        $venue = $doctrine->getRepository(Venue::class)->findOneById($id);

        $gallery = $doctrine->getRepository(Image::class)->findImagesByVenue($id);

        $managers = $venue->getManagers();
        $user = $this->getUser();
        $user_id = $user->getId();


        foreach ($managers as $manager) {
            $manager_id[] = $manager->getId();
        }

        $form = $this->createForm(VenueType::class, $venue, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($venue);
            $em->flush();

            $this->addFlash('success', 'Modification effectuée avec succès');
        }

        if (in_array($user_id, $manager_id)) {
            return $this->render('pages/venues/update.html.twig', [
                'venueForm' => $form->createView(), 'id' => $id, 'venue' => $venue, 'gallery' => $gallery
            ]);
        } else {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cet élément');
            return $this->redirectToRoute('homepage');
        }
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/venues/favorites", name="favorites-venues")
     */
    public function favoritesVenues(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $user = $this->getUser();

        if ($user) {
            $user_id = $user->getId();
            $venues = $doctrine->getRepository(Venue::class)->findFavoritesVenuesByUser($user_id);

          if ($venues) {

                  $paginator = $this->get('knp_paginator');
                  $pagination = $paginator->paginate(
                      $venues,
                      $request->query->getInt('page', 1),
                      $request->query->getInt('limit', 3)
                  );


          } else {
              $pagination = null;
          }

            return $this->render('pages/venues/favorites.html.twig', [
                'venues' => $pagination, 'events' => null
            ]);

        }
    }


    /** AFFICHER LA PAGE DU CAFE-CONCERT
     *
     * @Route("/venues/{slug}", name="venue"))
     */
    public function viewAction(YoutubeAPI $youtubeAPI, $slug)
    {
        $doctrine = $this->getDoctrine();
        $venue = $doctrine->getRepository(Venue::class)->findOneBy(['slug' => $slug]);
        $playlist = $venue->getVideoPlaylist();

        $user = $this->getUser();
        $venue_id = $venue->getId();

        $events = $doctrine->getRepository(Event::class)->findEventsByVenue($venue_id);



        $favorite = 'unliked';

        if ($playlist) {
            $regex = '/list=(.+)/';
            preg_match($regex, $playlist, $matches);
            $src = $matches[1];
            $videos = $youtubeAPI->getVideosFromPlaylist($src, 10);
        } else {
            $videos = null;
        }

        if ($user) {

            $favvenues = $user->getFavVenues();

            foreach ($favvenues as $favvenue) {
                $favvenue_id[] = $favvenue->getId();

                if (in_array($venue_id, $favvenue_id)) {

                    $favorite = 'liked';

                } else {

                    $favorite = 'unliked';

                }
            }

        }

        return $this->render('pages/venues/venue.html.twig', [
            'venue' => $venue, 'videos' => $videos, 'favorite' => $favorite, 'events'=>$events
        ]);
    }

}