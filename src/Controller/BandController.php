<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 28/03/18
 * Time: 20:44
 */

namespace App\Controller;


use App\Entity\Band;
use App\Entity\Image;
use App\Form\BandType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BandController extends Controller
{
    /** CREATION D'UN GROUPE
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("bands/new", name="band-new")
     * @Method({"GET", "POST"})
     */
    public function newBand(Request $request, FileUploader $fileUploader)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $band = new Band();
        $user = $this->getUser();

        $form = $this->createForm(BandType::class, $band, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $img = $band->getLogo();
            $file = $img->getFile();
            $fileName = $fileUploader->upload($file);

            $img->setUrl('/uploads/img/' . $fileName);
            $em = $this->getDoctrine()->getManager();

            $band->setMembers($user);

            $em->persist($band);
            $em->flush();

            $this->addFlash('success', 'Vous avez créé le groupe ' . $band->getName());

            return $this->redirectToRoute('homepage');
        }

        return $this->render("pages/bands/new.html.twig", [
            'bandForm' => $form->createView()
        ]);

    }

    /** LISTE LES GROUPES INSCRITS
     *
     * @Route("/bands", name="bands")
     */
    public function listBand(Request $request)
    {

        $doctrine = $this->getDoctrine();

        $bands = $doctrine->getRepository(Band::class)->findAll();

        //pagination
        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $bands,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)
        );

        return $this->render('pages/bands/bands.html.twig', [
            'bands' => $pagination
        ]);
    }


    /**
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("bands/update/{id}", name="bands-update")
     */
    public function updateBand(Request $request, FileUploader $fileUploader, $id)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $doctrine = $this->getDoctrine();
        $repo = $doctrine->getRepository(Band::class);
        $band = $repo->findOneById($id);

        $gallery = $doctrine->getRepository(Image::class)->findImagesByBand($id);

        $members = $band->getMembers();
        $user = $this->getUser();
        $id = $user->getId();

        foreach ($members as $member) {
            $member_id[] = $member->getId();
        }

        $form = $this->createForm(BandType::class, $band, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($band);
            $em->flush();

            $this->addFlash('success', 'Modification effectuée avec succès');


        }

        if (in_array($id, $member_id)) {
            return $this->render('pages/bands/update.html.twig', [
                'bandForm' => $form->createView(), 'id' => $id, 'band' => $band, 'gallery' => $gallery
            ]);
        } else {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cet élément');
            return $this->redirectToRoute('homepage');
        }

    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/bands/manage", name="bands-manage")
     */
    public function manageBands()
    {
        $user = $this->getUser();
        $id = $user->getId();
        $doctrine = $this->getDoctrine();
        $bands = $doctrine->getRepository(Band::class)->findBandsByUser($id);

        return $this->render('pages/bands/manage.html.twig', [
            'bands' => $bands
        ]);

    }

    /** AFFICHE LA PAGE DU GROUPE
     *
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("bands/{slug}", name="band")
     */
    public function showBand($slug)
    {

        $doctrine = $this->getDoctrine();

        $band = $doctrine->getRepository(Band::class)->findOneBy(['slug' => $slug]);


        return $this->render('pages/bands/band.html.twig', ['band' => $band]);

    }


}