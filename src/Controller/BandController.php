<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 28/03/18
 * Time: 20:44
 */

namespace App\Controller;


use App\Entity\Band;
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
    public function newAction(Request $request, FileUploader $fileUploader)
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

            $band->setUsers($user);

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
    public function listAction(Request $request)
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


    /** AFFICHE LA PAGE DU GROUPE
     *
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("bands/{slug}", name="band")
     */
    public function showAction($slug)
    {

        $doctrine = $this->getDoctrine();

        $band = $doctrine->getRepository(Band::class)->findOneBy(['slug' => $slug]);


        return $this->render('pages/bands/band.html.twig', ['band' => $band]);


    }


}