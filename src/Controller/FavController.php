<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 18/08/18
 * Time: 16:04
 */

namespace App\Controller;


use App\Entity\Band;
use App\Entity\Event;
use App\Entity\Venue;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavController extends Controller
{

    /**
     * @param Request $request
     * @Route("/favorites/{type}/{id}", name="favorites")
     * @return Response
     */
    public function likeBands(Request $request)
    {

        $doctrine = $this->getDoctrine();
        $user = $this->getUser();

        $type = $request->get('type');

        $liked = false;

        switch ($type) {

            case 'band':
                $band_id = $request->get('id');
                $band = $doctrine->getRepository(Band::class)->findOneById($band_id);

                $favoris = $user->getFavBands();

                foreach ($favoris as $favori) {

                    if ($band_id == $favori->getId()) {

                        $liked = true;
                    }
                }

                if (!$liked) {
                    $user->addFavBand($band);
                } else {
                    $user->removeFavBand($band);
                }

                break;

            case 'venue':
                $venue_id = $request->get('id');
                $venue = $doctrine->getRepository(Venue::class)->findOneById($venue_id);

                $favoris = $user->getFavVenues();

                foreach ($favoris as $favori) {

                    if ($venue_id == $favori->getId()) {

                        $liked = true;
                    }
                }

                if (!$liked) {
                    $user->addFavVenue($venue);
                } else {
                    $user->removeFavVenue($venue);
                }

                break;

            case 'event':
                $event_id = $request->get('id');
                $event = $doctrine->getRepository(Event::class)->findOneById($event_id);

                $favoris = $user->getFavEvents();

                foreach ($favoris as $favori) {

                    if ($event_id == $favori->getId()) {
                        $liked = true;
                    }
                }

                if (!$liked) {
                    $user->addFavEvent($event);
                } else {
                    $user->removeFavEvent($event);
                }

                break;

        }


        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response(null, 204);

    }




}