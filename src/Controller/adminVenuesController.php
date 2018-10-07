<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 6/10/18
 * Time: 07:44
 */

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Venue;
use App\Form\AdminVenueType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class adminVenuesController
 * @package App\Controller
 * @Security("is_granted('ROLE_ADMIN')")
 */
class adminVenuesController extends Controller
{


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/venues", name="admin-venues")
     */
    public function adminManageVenues(Request $request)
    {
        $doctrine = $this->getDoctrine();

        $venues = $doctrine->getRepository(Venue::class)->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $venues,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render('pages/admin/venues/venues.html.twig', [
            'venues' => $pagination
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/venues/update/{id}", name="admin-venues-update")
     */
    public function adminUpdateVenues(Request $request, $id){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $doctrine = $this->getDoctrine();
        $repo = $doctrine->getRepository(Venue::class);
        $venue = $repo->findOneById($id);


        $form = $this->createForm(AdminVenueType::class, $venue, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($venue);
            $em->flush();

            $this->addFlash('success', 'Modification effectuée avec succès');
        }


        return $this->render('pages/admin/venues/update.html.twig', [
            'venueForm' => $form->createView(), 'id' => $id, 'venue' => $venue
        ]);

    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/venues/gallery/{id}", name="admin-venues-gallery")
     */
    public function adminImageVenues($id){

        $doctrine = $this->getDoctrine();

        $venue = $doctrine->getRepository(Venue::class)->findOneById($id);
        $venue_id = $venue->getId();

        $gallery = $doctrine->getRepository(Image::class)->findImagesByVenue($venue_id);


        return $this->render('pages/admin/venues/gallery.html.twig', [
            'gallery'=>$gallery, 'venue'=>$venue
        ]);
    }

}