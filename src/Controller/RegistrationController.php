<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 6/04/18
 * Time: 13:21
 */

namespace App\Controller;


use App\Entity\TempUser;
use App\Form\RulesType;
use App\Form\TempUserType;
use App\Service\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class RegistrationController extends Controller
{

    /** INSCRIPTION D'UN NOUVEL UTILISATEUR
     *
     * @param Request $request
     * @return mixed
     * @Route("/registration", name="registration")
     * @Method({"GET", "POST"})
     */
    public function registration(Request $request, EncoderFactoryInterface $encoderFactory, Mailer $mailer)
    {
        //créer un utilisateur temporaire
        $tempuser = new TempUser();

        $form = $this->createForm(TempUserType::class, $tempuser, ['method' => 'POST']);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            //hashage du password
            $plainPassword = $tempuser->getPassword();
            $encoder = $encoderFactory->getEncoder($tempuser);
            $encoded = $encoder->encodePassword($plainPassword, '');

            $registrationdate = $tempuser->getRegistrationDate()->format('d-m-Y');
            $mail = $tempuser->getMail();

            //création d'un token unique
            $token = sha1($registrationdate . $mail);

            $tempuser->setToken($token);
            $tempuser->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tempuser);
            $em->flush();

            $this->addFlash('success', 'Veuillez confirmer votre inscription via le mail envoyé (pensez à vérifier dans les indésirables)');

            //envoi du mail avec le service Mailer
            $subject = 'Nouvelle inscription';
            $body = $this->renderView('pages/registration/registration-mail.html.twig', array('tempuser' => $tempuser));

            $mailer->sendMail($mail, $subject, $body);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('pages/registration/registration.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/confidential", name="confidential")
     * @Method({"GET", "POST"})
     */
    public function confidentiality(Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        $id = $user->getId();

        $form = $this->createForm(RulesType::class, $user, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }


        return $this->render('pages/registration/conf-rules.html.twig', [
            'rulesForm' => $form->createView(), 'id' => $id
        ]);

    }
}