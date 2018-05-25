<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 29/03/18
 * Time: 13:46
 */

namespace App\Controller;


use App\Entity\Venue;
use App\Form\VenueType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VenueController extends Controller
{

    /** CREER UN NOUVEAU CAFE-CONCERT
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return string
     * @Route("venues/new", name="venue-new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request, FileUploader $fileUploader)
    {

        $venue = new Venue();

        $user = $this->getUser();

        $form = $this->createForm(VenueType::class, $venue, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // upload de l'image
            $img = $venue->getPhoto();
            $file = $img->getFile();
            $fileName = $fileUploader->upload($file);

            $img->setUrl('/uploads/img/'.$fileName);

            $em = $this->getDoctrine()->getManager();

            // l'utilisateur est considéré comme gestionnaire du profil café-concert
            $venue->setUsers($user);

            $em->persist($venue);
            $em->flush();

            $this->addFlash('success', 'Vous avez créé la salle de spectacle' .$venue->getName());

            return $this->redirectToRoute('homepage');

        }
        return $this->render('pages/venues/new.html.twig', [
            'venueForm'=>$form->createView()
        ]);
    }

    /** LISER LES CAFES-CONCERT
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/venues", name="venues")
     */
    public function listAction(Request $request)
    {

        $doctrine = $this->getDoctrine();

        $venues = $doctrine->getRepository(Venue::class)->findAll();

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

    /** AFFICHER LA PAGE DU CAFE-CONCERT
     *
     * @Route("/venues/{slug}", name="venue"))
     */
    public function viewAction($slug)
    {
        $dotrine = $this->getDoctrine();

        $venue = $dotrine->getRepository(Venue::class)->findOneBy(['slug' => $slug]);

        return $this->render('pages/venues/venue.html.twig', [
            'venue' => $venue
        ]);
    }

}