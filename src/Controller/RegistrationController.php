<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 6/04/18
 * Time: 13:21
 */

namespace App\Controller;


use App\Entity\TempUser;
use App\Form\TempUserType;
use App\Service\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class RegistrationController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     * @Route("/registration", name="registration")
     * @Method({"GET", "POST"})
     */
    public function preRegistration(Request $request, EncoderFactoryInterface $encoderFactory, Mailer $mailer)
    {

        $tempuser = new TempUser();

        $form = $this->createForm(TempUserType::class, $tempuser, ['method'=>'POST']);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){

            $plainPassword = $tempuser->getPassword();
            $encoder = $encoderFactory->getEncoder($tempuser);
            $encoded = $encoder->encodePassword($plainPassword, '');

            $registrationdate = $tempuser->getRegistrationDate()->format('d-m-Y');
            $mail = $tempuser->getEMail();

            $token = sha1($encoded.$registrationdate.$mail);

            $tempuser->setToken($token);
            $tempuser->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tempuser);
            $em->flush();

            $this->addFlash('success', 'Veuillez confirmer votre inscription via le mail envoyé');

            $subject = 'Nouvelle inscription';
            $body = $this->renderView('pages/registration/registration-mail.html.twig', array('tempuser'=>$tempuser));

            $mailer->sendMail($mail, $subject, $body);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('pages/registration/registration.html.twig', [
            'form'=>$form->createView(),
        ]);

    }
}