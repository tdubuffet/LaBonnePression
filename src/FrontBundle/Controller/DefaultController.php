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

        $repoInstitution = $this->getDoctrine()
            ->getRepository('InstitutionBundle:Institution');

        $parisDisctrict = $repoInstitution->countParisDisctrict();
        $popularCity    = $repoInstitution->getCitiesInIleDeFrance(8);

        $departements = [
            77 => [
                'name' => 'Seine-et-Marne',
                'data' => $repoInstitution->countByDepartement(77)
            ],
            78 => [
                'name' => 'Yvelines',
                'data' => $repoInstitution->countByDepartement(78)
            ],
            91 => [
                'name' => 'Essonne',
                'data' => $repoInstitution->countByDepartement(91)
            ],
            92 => [
                'name' => 'Hauts-de-Seine',
                'data' => $repoInstitution->countByDepartement(92)
            ],
            93 => [
                'name' => 'Seine-Saint-Denis',
                'data' => $repoInstitution->countByDepartement(93)
            ],
            94 => [
                'name' => 'Val-de-Marne',
                'data' => $repoInstitution->countByDepartement(94)
            ],
            95 => [
                'name' => 'Val-d\'Oise',
                'data' => $repoInstitution->countByDepartement(95)
            ]
        ];


        return $this->render('FrontBundle:Default:index.html.twig', array(
            'paris' => $parisDisctrict,
            'popularCity' => $popularCity,
            'departements' => $departements
        ));
    }
}
