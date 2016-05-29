<?php

namespace FrontBundle\Controller;

use Elastica\Query\Filtered;
use Elastica\Query\GeoDistance;
use Elastica\Query\MatchAll;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * @Route("/recherche/{cityName}")
     */
    protected function searchAction(Request $request)
    {

        $finder = $this->get('fos_elastica.finder.app.institution');
        $query = new \Elastica\Query();

        $boolQuery = new \Elastica\Query\BoolQuery();

        $cityname   = $request->get('cityName', null);
        $postalCode = $request->get('postalCode', null);

        $location = $this->getDoctrine()
            ->getRepository('InstitutionBundle:ReferentialLocation')
            ->findOneBySlug($request->get('citySlug'));

        if($cityname && !$postalCode && !$location) {
            $fieldQuery = new \Elastica\Query\Match();
            $fieldQuery->setFieldQuery('city', $cityname);
            $fieldQuery->setFieldParam('city', 'analyzer', 'custom_french_analyzer');
            $boolQuery->addShould($fieldQuery);
        }

        if($postalCode && !$location) {

            $fieldQuery = new \Elastica\Query\Match();
            $fieldQuery->setFieldQuery('postalCode', $postalCode);
            $boolQuery->addShould($fieldQuery);
        }


        if ($location) {


            $fieldQuery = new \Elastica\Query\Match();
            $fieldQuery->setFieldQuery('postalCode', $location->getPostalCode());
            $boolQuery->addShould($fieldQuery);


            //$filter = new GeoDistance('location', array('lat' => $location->getLatitude(), 'lon' => $location->getLongitude()), '5km');
            //$query->setPostFilter($filter);
        }


        $query->setQuery($boolQuery);

        $query->setSort(array('googleRating' => array('order' => 'desc')));

        $results = $finder->findPaginated($query);
        $results->setMaxPerPage(100);
        $results->setCurrentPage($request->get('page', 1));


        return array(
            'results' => $results,
            'location' => $location
        );
    }

    /**
     * @Route("/ville/{cityName}+{postalCode}", name="search_city")
     */
    public function searchCityAction(Request $request)
    {
        return $this->render('FrontBundle:Search:index.html.twig', $this->searchAction($request));
    }

    /**
     * @Route("/recherche/ville/{citySlug}", name="search_city_geolocalisation")
     */
    public function searchCityGeolocalisationAction(Request $request)
    {
        return $this->render('FrontBundle:Search:index.html.twig', array_merge(
            $this->searchAction($request),
            [
                'level' => 'city'
            ]
        ));
    }
}
