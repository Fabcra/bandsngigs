<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 19/04/18
 * Time: 17:42
 */

namespace App\Controller;


use App\Entity\Band;
use App\Entity\Image;
use App\Form\ImageType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{

    /** INSERTION D'UN AVATAR
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

        $user = $this->getUser();
        $id = $user->getId();

        $type = $request->get('type'); // Quel est le type de l'image ? logo ou avatar

        $band_id = $request->get('id');

        // si le type est logo, récupérer le groupe avec l'id envoyé
        if ($type === 'logo') {
            $doctrine = $this->getDoctrine();
            $repo = $doctrine->getRepository(Band::class);
            $band = $repo->findOneById($band_id);
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


            if ($type === 'avatar') {
                $user->setAvatar($image);

                $em->persist($user);
            } else if
            ($type === 'logo') {

                $band->setLogo($image);
                $em->persist($band);
            }

            $em->flush();

            $this->addFlash('success', 'Image insérée avec succès');

            if ($type === 'avatar') {
                return $this->redirectToRoute('profile');
            } else {

                return $this->redirectToRoute('bands-update', ['id' => $band_id, 'band'=>$band]);
            }

        }

        if ($type === "logo") {
            return $this->render('pages/bands/logo.html.twig', [
                'imgForm' => $form->createView(), 'id' => $band_id, 'band'=>$band
            ]);
        }
    }

    /**
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/bands/gallery/new/{id}", name="gallery-image-new")
     * @Method({"GET","POST"})
     */
    public function addImageGallery(Request $request, FileUploader $fileUploader)
    {
        $band_id = $request->get('id');
        $doctrine = $this->getDoctrine();
        $band = $doctrine->getRepository(Band::class)->findOneById($band_id);
        $gallery = $doctrine->getRepository(Image::class)->findImagesByBand($band_id);

        $user_id = $this->getUser()->getId();
        $members = $band->getMembers();


        $image = new Image();

        $form = $this->createForm(ImageType::class, $image, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $image->getFile();
            $filename = $fileUploader->upload($file);

            $image->setBand($band);
            $image->setUrl('/uploads/img/' . $filename);

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();
            $this->addFlash('success', 'image ajoutée à la galerie');


            foreach ($members as $member) {
                $member_id[] = $member->getId();
            }

            if (in_array($user_id, $member_id)) {
                return $this->redirectToRoute('bands-update', ['id' => $band_id, 'band'=>$band]);
            } else {
                $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cet élément');
                return $this->redirectToRoute('homepage');
            }

        }
        foreach ($members as $member) {
            $member_id[] = $member->getId();
        }

        if (in_array($user_id, $member_id)) {

            return $this->render('pages/bands/gallery.html.twig', [
                'galleryForm' => $form->createView(), 'id' => $band_id, 'gallery' => $gallery, 'band'=>$band
            ]);

        } else {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cet élément');
            return $this->redirectToRoute('homepage');
        }

    }

    /**
     * @param Request $request
     * @param $img_id
     * @return Response
     * @Route("/bands/gallery/delete/{band_id}/{img_id}", name="gallery-image-delete")
     */
    public function removeImageGallery(Request $request, $img_id)
    {
        $em = $this->getDoctrine()->getManager();

        $image = $em->getRepository(Image::class)->find($img_id);

        $band_id = $request->get('band_id');

        $band = $em->getRepository(Band::class)->findOneById($band_id);
        $em->remove($image);

        $em->persist($band);
        $em->flush();

        return new Response(null, 204);
    }

}