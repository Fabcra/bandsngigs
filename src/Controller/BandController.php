<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 28/03/18
 * Time: 20:44
 */

namespace App\Controller;


use App\Entity\Band;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BandController extends Controller
{

    /**
     * @Route("/bands", name="bands")
     */
    public function listAction(Request $request)
    {

        $doctrine = $this->getDoctrine();

        $bands = $doctrine->getRepository(Band::class)->findAll();

        $paginator= $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $bands,
            $request->query->getInt('page',1),
            $request->query->getInt('limit', 6)
        );

        return $this->render('pages/bands/bands.html.twig',[
            'bands'=>$pagination
            ]);
    }


    /**
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("bands/{slug}", name="band")
     */
    public function showAction($slug)
    {

        $doctrine = $this->getDoctrine();

        $band = $doctrine->getRepository(Band::class)->findOneBy(['slug'=>$slug]);


        return $this->render('pages/bands/band.html.twig',['band'=>$band]);


    }
}