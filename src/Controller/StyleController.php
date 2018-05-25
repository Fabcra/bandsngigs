<?php
/**
 * Created by PhpStorm.
 * User: Fab
 * Date: 5/04/18
 * Time: 18:14
 */

namespace App\Controller;


use App\Entity\Style;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StyleController extends Controller
{

    /** LISTER LES STYLES (non utilisé)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listStyle()
    {
        $doctrine = $this->getDoctrine();

        $styles = $doctrine->getRepository(Style::class)->findAll();

        return $this->render('pages/default/minisearchbar.html.twig', ['styles' => $styles]);
    }

}