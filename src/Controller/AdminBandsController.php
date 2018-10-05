<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 5/10/18
 * Time: 21:26
 */

namespace App\Controller;


use App\Entity\Band;
use App\Entity\Image;
use App\Form\AdminBandType;
use App\Form\BandType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminBandsController
 * @package App\Controller
 * @Security("is_granted('ROLE_ADMIN')")
 */
class AdminBandsController extends Controller
{


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/bands", name="admin-bands")
     */
    public function adminManageBands(Request $request)
    {

        $doctrine = $this->getDoctrine();

        $bands = $doctrine->getRepository(Band::class)->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $bands,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render('pages/admin/bands/bands.html.twig', [
            'bands' => $pagination
        ]);
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/bands/update/{id}",name="admin-bands-update")
     */
    public function adminUpdateBands(Request $request, $id)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $doctrine = $this->getDoctrine();
        $repo = $doctrine->getRepository(Band::class);
        $band = $repo->findOneById($id);

        $gallery = $doctrine->getRepository(Image::class)->findImagesByBand($id);

        $form = $this->createForm(AdminBandType::class, $band, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($band);
            $em->flush();

            $this->addFlash('success', 'Modification effectuée avec succès');
        }


        return $this->render('pages/admin/bands/update.html.twig', [
            'bandForm' => $form->createView(), 'id' => $id, 'band' => $band, 'gallery' => $gallery
        ]);

    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/bands/gallery/{id}", name="admin-bands-gallery")
     */
    public function adminImageBands($id)
    {

        $doctrine = $this->getDoctrine();

        $band = $doctrine->getRepository(Band::class)->findOneById($id);
        $band_id = $band->getId();

        $gallery = $doctrine->getRepository(Image::class)->findImagesByBand($band_id);


        return $this->render('pages/admin/bands/gallery.html.twig', [
           'gallery'=>$gallery, 'band'=>$band
        ]);

    }




}