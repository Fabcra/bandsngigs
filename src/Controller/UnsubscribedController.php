<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 28/05/18
 * Time: 15:43
 */

namespace App\Controller;


use App\Entity\UnscribedMember;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UnsubscribedController extends Controller
{

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("unscribedmember/delete/{id}", name="unscribed_member_delete")
     * @Method("DELETE")
     */
    public function deleteMember($id){

        $member = $this->getDoctrine()->getRepository(UnscribedMember::class)->findOneById($id);

        $em = $this->getDoctrine()->getManager();

        $em->remove($member);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

}