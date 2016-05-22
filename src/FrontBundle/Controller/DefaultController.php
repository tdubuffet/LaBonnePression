<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {

        $parisDisctrict = $this->getDoctrine()
            ->getRepository('InstitutionBundle:Institution')
            ->countParisDisctrict();


        return $this->render('FrontBundle:Default:index.html.twig', array(
            'paris' => $parisDisctrict
        ));
    }
}
