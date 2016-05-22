<?php

namespace FrontBundle\Controller;

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

        $boolQuery = new \Elastica\Query\BoolQuery();

        $cityname   = $request->get('cityName', null);
        $postalCode = $request->get('postalCode', null);

        if($cityname && !$postalCode) {
            $fieldQuery = new \Elastica\Query\Match();
            $fieldQuery->setFieldQuery('city', $cityname);
            $fieldQuery->setFieldParam('city', 'analyzer', 'custom_french_analyzer');
            $boolQuery->addShould($fieldQuery);
        }

        if($postalCode) {

            $fieldQuery = new \Elastica\Query\Match();
            $fieldQuery->setFieldQuery('postalCode', $postalCode);
            $boolQuery->addShould($fieldQuery);
        }


        $query = new \Elastica\Query();
        $query->setQuery($boolQuery);

        $query->setSort(array('googleRating' => array('order' => 'desc')));

        $results = $finder->findPaginated($query);
        $results->setMaxPerPage(27);
        $results->setCurrentPage($request->get('page', 1));

        return array(
            'results' => $results
        );
    }

    /**
     * @Route("/ville/{cityName}+{postalCode}", name="search_city")
     */
    public function searchCityAction(Request $request)
    {
        return $this->render('FrontBundle:Search:index.html.twig', $this->searchAction($request));
    }
}
