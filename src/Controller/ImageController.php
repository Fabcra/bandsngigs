<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 19/04/18
 * Time: 17:42
 */

namespace App\Controller;


use App\Entity\Band;
use App\Entity\Event;
use App\Entity\Image;
use App\Entity\User;
use App\Entity\Venue;
use App\Form\ImageType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{

    /** INSERTION D'AVATAR, LOGO, FLYERS
     *
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/image/{type}/{id}", name="image")
     */
    public function insertImage(Request $request, FileUploader $fileUploader)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $image = new Image();

        $type = $request->get('type'); // Quel est le type de l'image ? logo, avatar ou photo
        $doctrine = $this->getDoctrine();

        $user = $this->getUser();
        $user_id = $user->getId();

        switch ($type) {

            // si le type est avatar, récupérer l'utilisateur
            case "avatar":
                $user = $this->getUser();
                $user_id = $user->getId();

                $id = $request->get('id');


                if ($id != $user_id){
                    $this->addFlash('danger', 'Vous n\'êtes pas l\'utilisateur correspondant à cette url');
                    return $this->redirectToRoute('homepage');

                }
                break;

            // si le type est logo, récupérer le groupe avec l'id envoyé
            case "logo":
                $band_id = $request->get('id');
                $band = $doctrine->getRepository(Band::class)->findOneById($band_id);

                $members = $band->getMembers();

                foreach ($members as $member){

                    $member_id[] = $member->getId();

                    if (!in_array($user_id, $member_id)){
                        $this->addFlash('danger', 'vous ne pouvez pas modifier cette image sans être membre du groupe');
                        return $this->redirectToRoute('homepage');
                    }
                }

                break;

            //si le type est photo, récupérer le café-concert avec l'id envoyé
            case "photo":
                $venue_id = $request->get('id');
                $venue = $doctrine->getRepository(Venue::class)->findOneById($venue_id);

                $managers = $venue->getManagers();

                foreach ($managers as $manager) {

                    $manager_id[] = $manager->getId();
                    if (!in_array($user_id, $manager_id)){
                        $this->addFlash('danger', 'vous ne pouvez pas modifier cette image sans être membre du café-concert');
                        return $this->redirectToRoute('homepage');
                    }
                }
                break;

            case "flyer":
                $event_id = $request->get('id');
                $event = $doctrine->getRepository(Event::class)->findOneById($event_id);

                $organiser = $event->getOrganiser();

                $organiser_id = $organiser->getId();

                if ($organiser_id !== $user_id){
                    $this->addFlash('danger', 'vous ne pouvez pas modifier cette image sans être l\'organisateur du concert');
                    return $this->redirectToRoute('homepage');
                }
                break;
        }

        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //upload de l'image
            $file = $image->getFile();
            $filename = $fileUploader->upload($file);
            $image->setUrl('/uploads/img/' . $filename);



            $em = $this->getDoctrine()->getManager();
            $em->persist($image);


            switch ($type) {

                case 'avatar':
                    $user->setAvatar($image);
                    $em->persist($user);
                    break;

                case 'logo':
                    $band->setLogo($image);
                    $em->persist($band);
                    break;

                case 'photo':
                    $venue->setPhoto($image);
                    $em->persist($venue);
                    break;

                case "flyer":
                    $event->setFlyer($image);
                    $em->persist($event);
                    break;
            }



            $em->flush();
            $this->addFlash('success', 'Image insérée avec succès');

            switch ($type) {

                case "avatar":
                    return $this->redirectToRoute('profile');
                    break;

                case "logo":
                    return $this->redirectToRoute('bands-update', ['id' => $band_id, 'band' => $band]);
                    break;


                case "photo":
                    return $this->redirectToRoute('venues-update', ['id' => $venue_id, 'venue' => $venue]);
                    break;

                case "flyer":
                    return $this->redirectToRoute('events-update', ['id' => $event_id, 'event' => $event]);
                    break;
            }

        }

        switch ($type) {
            case "avatar":
                return $this->render('pages/users/avatar.html.twig', [
                    'imgForm' => $form->createView(), 'id' => $user_id
                ]);
                break;

            case "logo":
                return $this->render('pages/bands/logo.html.twig', [
                    'imgForm' => $form->createView(), 'id' => $band_id, 'band' => $band
                ]);
                break;

            case "photo":
                return $this->render('pages/venues/photo.html.twig', [
                    'imgForm' => $form->createView(), 'id' => $venue_id, 'venue' => $venue
                ]);
                break;

            case "flyer":
                return $this->render('pages/events/flyer.html.twig', [
                    'imgForm' => $form->createView(), 'id' => $event_id, 'event' => $event
                ]);
                break;
        }
    }

    /**
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/gallery/{type}/{id}", name="gallery-image-new")
     * @Method({"GET","POST"})
     */
    public function addImageGallery(Request $request, FileUploader $fileUploader)
    {
        $doctrine = $this->getDoctrine();
        $type = $request->get('type'); // venue ou band ?

        if ($type === 'band') {
            $band_id = $request->get('id');
            $band = $doctrine->getRepository(Band::class)->findOneById($band_id);
            $gallery = $doctrine->getRepository(Image::class)->findImagesByBand($band_id);
            $members = $band->getMembers();
        }

        if ($type === 'venue') {
            $venue_id = $request->get('id');
            $venue = $doctrine->getRepository(Venue::class)->findOneById($venue_id);
            $gallery = $doctrine->getRepository(Image::class)->findImagesByVenue($venue_id);
            $managers = $venue->getManagers();
        }

        $user_id = $this->getUser()->getId();


        $image = new Image();

        $form = $this->createForm(ImageType::class, $image, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $image->getFile();
            $filename = $fileUploader->upload($file);

            if ($type === 'band') {
                $image->setBand($band);
                $image->setUrl('/uploads/img/' . $filename);
            }

            if ($type === 'venue') {
                $image->setVenue($venue);
                $image->setUrl('/uploads/img/' . $filename);
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();
            $this->addFlash('success', 'image ajoutée à la galerie');


            if ($type === 'band') {
                foreach ($members as $member) {
                    $member_id[] = $member->getId();
                }
                if (in_array($user_id, $member_id)) {
                    return $this->redirectToRoute('bands-update', ['id' => $band_id, 'band' => $band]);
                } else {
                    $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cet élément');
                    return $this->redirectToRoute('homepage');
                }
            }

            if ($type === 'venue') {
                foreach ($managers as $manager) {
                    $manager_id[] = $manager->getId();
                }
                if (in_array($user_id, $manager_id)) {
                    return $this->redirectToRoute('venues-update', ['id' => $venue_id, 'venue' => $venue]);
                } else {
                    $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cet élément');
                    return $this->redirectToRoute('homepage');
                }
            }


        }

        if ($type === 'band') {
            foreach ($members as $member) {
                $member_id[] = $member->getId();
            }
            if (in_array($user_id, $member_id)) {
                return $this->render('pages/bands/gallery.html.twig', [
                    'galleryForm' => $form->createView(), 'id' => $band_id, 'gallery' => $gallery, 'band' => $band
                ]);
            } else {
                $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cet élément');
                return $this->redirectToRoute('homepage');
            }
        }

        if ($type === 'venue') {
            foreach ($managers as $manager) {
                $manager_id[] = $manager->getId();
            }
            if (in_array($user_id, $manager_id)) {
                return $this->render('pages/venues/gallery.html.twig', [
                    'galleryForm' => $form->createView(), 'id' => $venue_id, 'gallery' => $gallery, 'venue' => $venue
                ]);
            } else {
                $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cet élément');
                return $this->redirectToRoute('homepage');
            }
        }


    }

    /**
     * @param Request $request
     * @param $img_id
     * @return Response
     * @Route("/bands/gallery/delete/{type}/{id}/{img_id}", name="gallery-image-delete")
     */
    public function removeImageGallery(Request $request, $img_id)
    {
        $type = $request->get('type');
        $em = $this->getDoctrine()->getManager();

        $image = $em->getRepository(Image::class)->find($img_id);

        if ($type === 'band') {
            $band_id = $request->get('id');
            $band = $em->getRepository(Band::class)->findOneById($band_id);
        }

        if ($type === 'venue') {
            $venue_id = $request->get('id');
            $venue = $em->getRepository(Venue::class)->findOneById($venue_id);
        }

        $em->remove($image);

        if ($type === 'band') {
            $em->persist($band);
        }
        if ($type === 'venue') {
            $em->persist($venue);
        }

        $em->flush();

        return new Response(null, 204);
    }

}