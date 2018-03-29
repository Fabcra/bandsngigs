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
use App\Entity\Venue;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @return Response
     * @Route("/", name="homepage")
     */
    public function index()
    {

        $doctrine = $this->getDoctrine();
        $bands = $doctrine->getRepository(Band::class)->findAll();
        $venues = $doctrine->getRepository(Venue::class)->findAll();
        $events = $doctrine->getRepository(Event::class)->findAll();



        return $this->render('pages/homepage/home.html.twig', [
            'bands' => $bands,
            'venues' => $venues,
            'events' => $events

        ]);
    }

}