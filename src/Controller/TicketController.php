<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 25/06/18
 * Time: 10:47
 */

namespace App\Controller;


use App\Entity\Event;
use App\Entity\Ticket;
use App\Form\TicketType;
use Endroid\QrCode\QrCode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PDFShift\PDFShift;

class TicketController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/tickets/new/{event_id}", name="ticket-new")
     * @Method({"GET", "POST"})
     */
    public function newTicket(Request $request, $event_id)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $ticket = new Ticket();

        $user = $this->getUser();
        $quantity = $_GET["quantity"];


        $doctrine = $this->getDoctrine();

        $event = $doctrine->getRepository(Event::class)->findOneById($event_id);
        $slugevent = $event->getSlug();

        $unit_price = $event->getprice();

        $form = $this->createForm(TicketType::class, $ticket, ['method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ticket->setEvent($event);
            $spot_nb = $request->request->get('ticket');
            $spot_nb = $spot_nb['purchasedTicketsNb'];
            $total_amount = ($unit_price * $spot_nb);



            $amountCents = $total_amount * 100; //convertir le montant en centimes pour Stripe

            $ticket->setAmount($total_amount);
            $ticket->setSpectator($user);


            $verificationNB = sha1(uniqid(mt_rand(), true));

            //code QR
            //$qrCode = new QrCode('https://www.fabrice-crahay.be/tickets/check/' . $verificationNB);
            $qrCode = new QrCode('https://www.fabrice-crahay.be/events/'. $slugevent);

            $qrCode->setSize(300);

            $qrCode->writeFile(__DIR__ . '/../../public/uploads/qrcode/' . $verificationNB . '.png');

            $pdf = $verificationNB . '.pdf';
            $ticket->setVerificationNb($verificationNB);
            $ticket->setTicketPdf('public/uploads/pdf/' . $pdf);

            $em = $this->getDoctrine()->getManager();

            $em->persist($ticket);
            $em->flush();

            \Stripe\Stripe::setApiKey("sk_test_YGp0cxQPGb1LMy3dDcucNBSm");

            \Stripe\Charge::create(array(
                "amount" => $amountCents,
                "currency" => "eur",
                "source" => $request->request->get('stripeToken'),
                "description" => "commande de " . $spot_nb . " places pour " . $event->getName() . " au nom de " . $user->getLastName()
            ));

            $ticketid = $ticket->getId();


            PDFShift::setApiKey('e6fe654bc5f64d9c9cd9afdf8c350959');

            $data = file_get_contents('http://www.fabrice-crahay.be/tickets/' . $ticketid);
            PDFShift::convertTo($data, null, 'uploads/pdf/' . $pdf);



            //mail du ticket
            $mail = $user->getEmail();
            $subject = $event->getName();
            $body = $this->renderView('pages/tickets/ticket-mail.html.twig', array('ticket' => $ticket));
            $filepathURL = '../public/uploads/pdf/' . $pdf;


            $message = (new \Swift_Message($subject))
                ->setSubject($subject)
                ->setFrom('admin@bandsngigs.com')
                ->setTo($mail)
                ->setBody($body)
                ->setContentType("text/html")
                ->attach(\Swift_Attachment::fromPath($filepathURL));

            $this->get('mailer')->send($message);


            $this->addFlash('success', 'Votre achat est validé');

            return $this->redirectToRoute('homepage');

        }

        return $this->render('pages/tickets/new.html.twig', [
            'ticketForm' => $form->createView(),
            'quantity' => $quantity,
            'event' => $event
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("tickets/{id}", name="ticket")
     */
    public function showTicket($id)
    {
        $doctrine = $this->getDoctrine();
        $ticket = $doctrine->getRepository(Ticket::class)->findOneById($id);

        return $this->render('pages/tickets/ticket.html.twig', ['ticket' => $ticket]);
    }


}


