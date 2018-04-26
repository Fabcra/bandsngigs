<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 29/03/18
 * Time: 13:46
 */

namespace App\Controller;


use App\Entity\Venue;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VenueController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/venues", name="venues")
     */
    public function listAction(Request $request){

        $doctrine = $this->getDoctrine();

        $venues = $doctrine->getRepository(Venue::class)->findAll();

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
          $venues,
          $request->query->getInt('page',1),
          $request->query->getInt('limit',4)
        );

        return $this->render('pages/venues/venues.html.twig',[
           'venues'=>$pagination
        ]);

    }

    /**
     * @Route("/venues/{slug}", name="venue"))
     */
    public function viewAction($slug)
    {
        $dotrine = $this->getDoctrine();

        $venue = $dotrine->getRepository(Venue::class)->findOneBy(['slug'=>$slug]);

        return $this->render('pages/venues/venue.html.twig',[
            'venue'=>$venue
        ]);
    }

}