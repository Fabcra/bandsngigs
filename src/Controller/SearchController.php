<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 5/04/18
 * Time: 13:09
 */

namespace App\Controller;


use App\Entity\Band;
use App\Entity\Event;
use App\Entity\Style;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/search", name="search")
     */
    public function searchForEvents(Request $request)
    {

        $params['by_band'] = $request->query->get('by_band');
        $params['by_location'] = $request->query->get('by_location');
        $params['by_style'] = $request->query->get('by_style');


        $doctrine = $this->getDoctrine();

        $styles = $doctrine->getRepository(Style::class)->findAll();

        $bands = $doctrine->getRepository(Band::class)->findAll();

        $repo = $doctrine->getRepository(Event::class);

        $events = $repo->search($params);


        $paginator = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $events,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 4)
        );


        return $this->render('pages/events/events.html.twig',
            [
                'bands' => $bands,
                'styles' => $styles,
                'events'=>$result,
                'params' => $params
            ]);


    }

}