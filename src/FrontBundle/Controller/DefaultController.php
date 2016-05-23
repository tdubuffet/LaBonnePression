<?php

namespace FrontBundle\Controller;

use InstitutionBundle\Form\SearchLocationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {

        $locationId = $request->get('location', null);

        if ($locationId) {

            $location = $this->getDoctrine()
                ->getRepository('InstitutionBundle:ReferentialLocation')
                ->find($locationId);

            return $this->redirectToRoute('search_city_geolocalisation', array(
                'cityId' => $location->getId(),
                'cityName' => $location->getName(),
                'lat' => $location->getLatitude(),
                'lng' => $location->getLongitude(),
            ));
        }

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
