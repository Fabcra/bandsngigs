<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 29/03/18
 * Time: 10:10
 */

namespace App\Controller;

use App\Entity\Band;
use App\Entity\Event;
use App\Entity\Style;
use App\Entity\Venue;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

    /** HOMEPAGE
     * @return Response
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $doctrine = $this->getDoctrine();
        $bands = $doctrine->getRepository(Band::class)->findBandsWithLogo();
        $lastvenues = $doctrine->getRepository(Venue::class)->findVenuesWithPhoto();
        $events = $doctrine->getRepository(Event::class)->findEventsWithFlyer();
        $styles = $doctrine->getRepository(Style::class)->findAll();
        $venues = $doctrine->getRepository(Venue::class)->findActiveVenues();

        $user = $this->getUser();

        if ($user) {

            $valid = $user->getValid();

            if ($valid === false) {
               return $this->redirectToRoute('logout');
            }

            $confidentiality = $user->getConfidentiality();

            if ($confidentiality == 0) {
                return $this->redirectToRoute('confidential');
            }
        }


        return $this->render('pages/homepage/home.html.twig', [
            'bands' => $bands,
            'lastvenues' => $lastvenues,
            'events' => $events,
            'styles' => $styles,
            'venues' => $venues

        ]);

    }

}