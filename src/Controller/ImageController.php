<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 19/04/18
 * Time: 17:42
 */

namespace App\Controller;


use App\Entity\Image;
use App\Form\ImageType;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ImageController extends Controller
{

    /**
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/image", name="image")
     */
    public function insertAvatar(Request $request, FileUploader $fileUploader){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $image = new Image();

        $user = $this->getUser();
        $id = $user->getId();


        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $file = $image->getFile();
            $filename = $fileUploader->upload($file);
            $image->setUrl('/uploads/img/'.$filename);

            $em= $this->getDoctrine()->getManager();
            $em->persist($image);

            $user->setAvatar($image);

            $em->persist($user);


            $em->flush();


            $this->addFlash('success', 'Image insérée avec succès');

            return $this->redirectToRoute('profile');

        }

        return $this->render('pages/images/new-avatar.html.twig', [
            'imgForm' => $form->createView(), 'id'=>$id
        ]);


    }

}