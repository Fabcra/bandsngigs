<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 29/03/18
 * Time: 13:46
 */

namespace App\Controller;


use App\Entity\Image;
use App\Entity\Venue;
use App\Form\BandType;
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

            $img->setUrl('/uploads/img/' . $fileName);

            $em = $this->getDoctrine()->getManager();

            // l'utilisateur est considéré comme gestionnaire du profil café-concert
            $venue->setManagers($user);

            $em->persist($venue);
            $em->flush();

            $this->addFlash('success', 'Vous avez créé la salle de spectacle' . $venue->getName());

            return $this->redirectToRoute('homepage');

        }
        return $this->render('pages/venues/new.html.twig', [
            'venueForm' => $form->createView()
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
        $id = $user->getId();


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

        if (in_array($id, $manager_id)) {
            return $this->render('pages/venues/update.html.twig', [
                'venueForm' => $form->createView(), 'id' => $id, 'venue' => $venue, 'gallery' => $gallery
            ]);
        } else {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cet élément');
            return $this->redirectToRoute('homepage');
        }
    }


    /** AFFICHER LA PAGE DU CAFE-CONCERT
     *
     * @Route("/venues/{slug}", name="venue"))
     */
    public function viewAction($slug)
    {
        $doctrine = $this->getDoctrine();

        $venue = $doctrine->getRepository(Venue::class)->findOneBy(['slug' => $slug]);

        return $this->render('pages/venues/venue.html.twig', [
            'venue' => $venue
        ]);
    }


}