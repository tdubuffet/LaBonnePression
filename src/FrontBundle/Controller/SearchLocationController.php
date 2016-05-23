<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchLocationController extends Controller
{
    /**
     * @Route("/ajax/city/locations", name="search_city_locations")
     */
    public function getLocationsAction(Request $request)
    {
        $q      = $request->query->get('q', null);
        $results    = [];

        if ($q) {



            $finder = $this->get('fos_elastica.finder.app.location');
            $query = new \Elastica\Query();

            $queryString = new \Elastica\Query\QueryString($q . '*');

            $queryString->setFields(array('name', 'postalCode'));

            $query->setQuery($queryString);


            $data = $finder->find($query, 10);

            foreach($data as $d) {
                $name = $d->getName();

                if (!empty($d->getPostalCode())) {
                    $name .= ' - ' . $d->getPostalCode();
                }

                $results[] = [
                    'id' => $d->getId(),
                    'text' => $name
                ];
            }
        }

        $response = new Response();
        $response->setContent(json_encode(array('items' => $results)));
        $response->headers->set('Content-Type', 'application/json');


        return $response;
    }


    /**
     * @Route("/ajax/city/location", name="search_city_location")
     */
    public function getLocationAction($id = null)
    {
        $book = $this->getDoctrine()->getRepository('AppBundle:Book')->find($id);

        return new Response($book->getName());
    }
}
