<?php

namespace CrawlerBundle\Command;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use InstitutionBundle\Entity\Institution;
use InstitutionBundle\Referentials\Paris;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlerBarGmapsCommand extends ContainerAwareCommand
{

    protected $google;

    protected function configure()
    {
        $this
            ->setName('crawler:bar:gmaps')
            ->setDescription('...')
            ->setDescription('Récupérer la liste des bars sur gmaps')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $googleApiKey   = $this->getContainer()->getParameter('google_api')['search_nav'];

        $this->google = new \joshtronic\GooglePlaces($googleApiKey);

        $institutionRepositoy = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository('InstitutionBundle:Institution');


        $postalCode = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository('InstitutionBundle:ReferentialCity');

        foreach ($postalCode->findAll() as $code) {


            $output->writeln('/**************************************** \/');
            $output->writeln('/******* ' . $code->getPostalCode() . ' ' . $code->getCity() .' ******* \/');
            $output->writeln('/**************************************** \/');

            $geoloc = $this->locationByName($code->getPostalCode() . ' ' . $code->getCity() .' Paris ');

            if (isset($geoloc['results'][0])) {

                $this->geoMaps(
                    $geoloc['results'][0]['geometry']['location']['lat'],
                    $geoloc['results'][0]['geometry']['location']['lng'],
                    $output,
                    $institutionRepositoy
                );
            }

        }

        $output->writeln('Done !');

        return ;

        $referentialsParis = (new Paris())->getDistrict();

        foreach ($referentialsParis as $j => $district) {


            $output->writeln('/**************************************** \/');
            $output->writeln('/******* ' . $j .' arrondissement ******* \/');
            $output->writeln('/**************************************** \/');

            foreach($district as $key => $quarter) {

                $output->writeln('------------------------------------------');
                $output->writeln('---------- ' . $quarter .'----------------');
                $output->writeln('------------------------------------------');

                $geoloc = $this->locationByName($quarter . ' Paris ');

                if (isset($geoloc['results'][0])) {

                    $this->geoMaps(
                        $geoloc['results'][0]['geometry']['location']['lat'],
                        $geoloc['results'][0]['geometry']['location']['lng'],
                        $output,
                        $institutionRepositoy
                    );
                }
            }
        }






        $output->writeln('Done !');


    }

    protected function geoMaps($lat, $lng, $output, $institutionRepositoy)
    {
        $this->google->location = array($lat, $lng);
        $this->google->radius   = 4000;
        $this->google->types    = 'bar';
        $this->google->language = 'fr';

        $response                = $this->google->radarSearch();


        do{

            $this->analyzer($response, $output, $institutionRepositoy);

            if (!isset($response['next_page_token']) || (isset($response['next_page_token']) && $response['next_page_token'] == '')) {
                break;
            }

            $output->writeln('/******* NEXT PAGE : ' . $response['next_page_token'] .'******* \/');

            $this->google->pagetoken = $response['next_page_token'];
            $response                = $this->google->radarSearch();

            if ($response['status'] != 'OK') {
                break;
            }

        } while(true);
    }

    protected function locationByName($districtName)
    {
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($districtName . ' France') . "&sensor=false";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geoloc = json_decode(curl_exec($ch), true);

        return $geoloc;
    }

    protected function analyzer($response, $output, $institutionRepositoy)
    {

        if ($response['status'] == 'OK') {

            foreach ($response['results'] as $result) {

                $output->writeln('------ Institution analyzer ' . $result['place_id'] . ' ------');

                $update = $institutionRepositoy->findOneByGooglePlaceId($result['place_id']);

                if ($update) {
                    $output->writeln('[' . $result['place_id'] . ']: Duplicate institution');
                }

                if (!$update) {
                    $details = $this->getDetailsByPlaceId($result['place_id']);


                    if ($details) {


                        $institution = new Institution();
                        $institution->setName($details['name']);
                        $institution->setFormattedAddress($details['formatted_address']);
                        $institution->setFormattedPhoneNumber(isset($details['formatted_phone_number']) ? $details['formatted_phone_number'] : null);
                        $institution->setFormattedInternationalPhoneNumber(isset($details['international_phone_number']) ? $details['international_phone_number'] : null);
                        $institution->setLatitude($result['geometry']["location"]["lat"]);
                        $institution->setLongitude($result['geometry']["location"]["lng"]);
                        $institution->setWebsite((isset($details['website'])) ? $details['website'] : null);
                        $institution->setGoogleId($result['id']);
                        $institution->setGooglePlaceId($result['place_id']);
                        $institution->setGoogleReference($result['reference']);
                        $institution->setGoogleRating(isset($details['rating']) ? $details['rating']: null);
                        $institution->setGoogleUserRatingsTotal(isset($details['user_ratings_total']) ? $details['user_ratings_total']: null);
                        $institution->setGoogleTypes($details['types']);
                        $institution->setGoogleAddressComponents($details['address_components']);

                        $postalCode = null;
                        $city = null;


                        foreach ($institution->getGoogleAddressComponents() as $comp) {

                            if (isset($comp['types'][0])) {
                                switch ($comp['types'][0]) {

                                    case 'postal_code':

                                        $postalCode = $comp['long_name'];

                                        break;


                                    case 'locality':

                                        $city = $comp['long_name'];

                                        break;

                                }

                                if ($postalCode && $city) {

                                    $institution->setCity($city);
                                    $institution->setPostalCode($postalCode);
                                }
                            }

                        }

                        try {
                            $this->getContainer()->get('doctrine')->resetManager();
                            $this->getContainer()->get('doctrine')->getManager()->persist($institution);
                            $this->getContainer()->get('doctrine')->getManager()->flush();
                            $output->writeln('[' . $result['place_id'] . ']: Insert institution');
                        }
                        catch (UniqueConstraintViolationException $e){
                            $output->writeln('[' . $result['place_id'] . ']: Error institution  - Duplicate values');
                        }

                        sleep(1);

                    }

                } else {
                    /**
                     *  On met à jour les données ?
                     */
                }
            }

        }
    }


    protected function getDetailsByPlaceId($placeId)
    {
        $this->google->placeid    = $placeId;
        $data = $this->google->details();

        if ($data['status'] == 'OK') {
            return $data['result'];
        }

        return false;
    }

}
