<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 28/03/18
 * Time: 20:44
 */

namespace App\Controller;


use App\Entity\Band;
use App\Entity\Event;
use App\Entity\Image;
use App\Form\BandType;
use App\Form\MediaBandType;
use App\Form\RemoveBandType;
use App\Service\FileUploader;
use App\Service\Mailer;
use App\Service\YoutubeAPI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

            $band->setActive(true);

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

        $bands = $doctrine->getRepository(Band::class)->findAllActiveBands();

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
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("bands/update/{id}", name="bands-update")
     */
    public function updateBand(Request $request, $id)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $doctrine = $this->getDoctrine();
        $repo = $doctrine->getRepository(Band::class);
        $band = $repo->findOneById($id);

        $active = $band->getActive();

        $gallery = $doctrine->getRepository(Image::class)->findImagesByBand($id);

        $members = $band->getMembers();
        $user = $this->getUser();
        $user_id = $user->getId();

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

        if ($active === true) {

            if (in_array($user_id, $member_id)) {
                return $this->render('pages/bands/update.html.twig', [
                    'bandForm' => $form->createView(), 'id' => $id, 'band' => $band, 'gallery' => $gallery
                ]);
            }
        } else {
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/bands/medias/{id}", name="bands-medias")
     */
    public function manageMedias($id, Request $request)
    {
        $doctrine = $this->getDoctrine();
        $band = $doctrine->getRepository(Band::class)->findOneBy(['id' => $id]);

        $form = $this->createForm(MediaBandType::class, $band, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();

            $em->persist($band);
            $em->flush();

            $this->addFlash('success', 'Modification effectuée avec succès');
        }

        return $this->render('pages/bands/medias.html.twig', [
            'mediaForm' => $form->createView(), 'band' => $band, 'id' => $id
        ]);

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/bands/favorites", name="favorites-bands")
     */
    public function favoritesBands(Request $request)
    {

        $doctrine = $this->getDoctrine();
        $user = $this->getUser();

        if ($user) {
            $user_id = $user->getId();
            $bands = $doctrine->getRepository(Band::class)->findFavoritesBandsByUser($user_id);


            if ($bands) {

                foreach ($bands as $band) {

                    $band_id = $band->getId();

                    $events = $doctrine->getRepository(Event::class)->findEventsByFavBands($user_id, $band_id);

                    $paginator = $this->get('knp_paginator');
                    $pagination = $paginator->paginate(
                        $bands,
                        $request->query->getInt('page', 1),
                        $request->query->getInt('limit', 3)

                    );

                }
            } else {
                $pagination = null;
                $events = null;
            }

            return $this->render('pages/bands/favorites.html.twig', [
                'bands' => $pagination, 'events' => $events, 'venues' => null
            ]);


        }
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/bands/remove/{id}", name="bands-remove")
     */
    public function removeBand(Request $request, $id, Mailer $mailer)
    {

        $doctrine = $this->getDoctrine();

        $band = $doctrine->getRepository(Band::class)->findOneById($id);
        $active = $band->getActive();
        $members = $band->getMembers();
        $user = $this->getUser();
        $user_id = $user->getId();

        foreach ($members as $member) {
            $member_id[] = $member->getId();
        }

        $form = $this->createForm(RemoveBandType::class, $band, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($band);
            $em->flush();

            $active = $band->getActive();


            //si actif est désactivé par l'utilisateur -> suppression du groupe
            if ($active === false) {

                $this->addFlash('success', 'Le groupe ' . $band->getName() . ' a été supprimé');

                foreach ($members as $member){

                    $mail = $member->getEmail();
                    $subject = 'Suppression de votre groupe';
                    $body = $this->renderView('pages/bands/cancellation-mail.html.twig',
                        array('user'=>$member, 'band'=>$band));

                    $mailer->sendMail($mail, $subject,$body);


                }


            }

            return $this->redirectToRoute('homepage');
        }

        if($active === true) {

            if (in_array($user_id, $member_id)) {
                return $this->render('pages/bands/remove.html.twig', [
                    'removeBandForm' => $form->createView(), 'id' => $id, 'band' => $band,
                ]);
            }
        } else{
            $this->addFlash('danger', 'ce groupe n\'est plus inscrit sur le site');
            return $this->redirectToRoute('homepage');

        }
    }


    /** AFFICHE LA PAGE DU GROUPE
     *
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("bands/{slug}", name="band")
     */
    public function showBand(YoutubeAPI $youtubeAPI, $slug)
    {
        $doctrine = $this->getDoctrine();
        $band = $doctrine->getRepository(Band::class)->findOneBy(['slug' => $slug]);

        $active = $band->getActive();

        $videoplaylist = $band->getVideoPlaylist();
        $audioplaylist = $band->getAudioPlaylist();

        $user = $this->getUser();
        $band_id = $band->getId();
        $events = $doctrine->getRepository(Event::class)->findEventsByBand($band_id);

        $favorite = 'unliked';


        if ($videoplaylist) {
            $regex = '/list=(.+)/';

            preg_match($regex, $videoplaylist, $matches);
            $src = $matches[1];
            $videos = $youtubeAPI->getVideosFromPlaylist($src, 10);

        } else {
            $videos = null;
        }

        if ($audioplaylist) {
            $regex2 = '/open\.spotify\.com\/(.+)/';
            preg_match($regex2, $audioplaylist, $matches);
            $audio = str_replace("/", ":", $matches[1]);

        } else {
            $audio = null;
        }

        if ($user) {

            $favbands = $user->getFavBands();

            foreach ($favbands as $favband) {
                $favband_id[] = $favband->getId();

                if (in_array($band_id, $favband_id)) {

                    $favorite = 'liked';
                } else {
                    $favorite = 'unliked';
                }
            }
        }

        if ($active === true) {
            return $this->render('pages/bands/band.html.twig', ['band' => $band, 'videos' => $videos, 'audio' => $audio, 'favorite' => $favorite, 'events' => $events]);
        }else{
            $this->addFlash('danger', 'Ce groupe n\'est plus enregistré sur ce site');
            return $this->redirectToRoute('homepage');
        }

    }


}