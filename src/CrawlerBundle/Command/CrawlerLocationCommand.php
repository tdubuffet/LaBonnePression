<?php

namespace CrawlerBundle\Command;

use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use InstitutionBundle\Entity\Institution;
use InstitutionBundle\Entity\ReferentialCity;
use InstitutionBundle\Entity\ReferentialLocation;
use InstitutionBundle\Referentials\Paris;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlerLocationCommand extends ContainerAwareCommand
{

    protected $google;

    protected $areaAuthorized = [77, 78, 91, 92, 93, 94, 95, 999];

    protected function configure()
    {
        $this
            ->setName('crawler:referential:location')
            ->setDescription('Importer toutes les codes postaux en france')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $departements = [
            77 => [
                'name' => 'Seine-et-Marne'
            ],
            78 => [
                'name' => 'Yvelines'
            ],
            91 => [
                'name' => 'Essonne'
            ],
            92 => [
                'name' => 'Hauts-de-Seine'
            ],
            93 => [
                'name' => 'Seine-Saint-Denis'
            ],
            94 => [
                'name' => 'Val-de-Marne'
            ],
            95 => [
                'name' => 'Val-d\'Oise'
            ]
        ];

        foreach ($departements as $key => $dep) {
            $this->addLocation($output, $dep['name'], $key, $key, false, 'department');
        }

        die;


        if (($handle = fopen(__DIR__ . '/../Resources/csv/postalCode.csv', "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

                $i++;

                if ($i == 1) continue;
                $region = substr($data[2], 0, 2);


                $this->addLocation($output, $data[1].' '.$data[2], $region, $data[2]);

            }
            fclose($handle);
        }



        $this->getContainer()->get('doctrine')->getManager()->flush();



    }

    protected function addLocation($output, $name, $region, $postalCode, $city = true, $type = 'city')
    {


        $institutionRepositoy = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository('InstitutionBundle:ReferentialLocation');

        $exists = $institutionRepositoy->findOneByPostalCode($postalCode);

        if (in_array($region, $this->areaAuthorized) && empty($exists)) {
            $values = $this->locationByName($name);

            if ($values['status'] == 'OK' && isset($values['results'][0])) {


                $referentialLocation = new ReferentialLocation();

                $referentialLocation->setType($type);

                foreach($values['results'][0]['address_components'] as $comp) {
;                    if ( in_array('locality', $comp['types']) && in_array('political', $comp['types']) && $type == 'city') {
                        $referentialLocation->setName($comp['long_name']);
                        $referentialLocation->setSlug($this->slugify($comp['long_name']));
                    }

                    if ( in_array('administrative_area_level_1', $comp['types']) && in_array('political', $comp['types'])) {
                        $referentialLocation->setRegionName($comp['long_name']);
                        $referentialLocation->setRegion($this->slugify($comp['long_name']));
                    }

                    if ( in_array('administrative_area_level_2', $comp['types']) && in_array('political', $comp['types']) && $type == 'city') {
                        $referentialLocation->setDepartmentName($comp['long_name']);
                    }


                    if ( in_array('administrative_area_level_2', $comp['types']) && in_array('political', $comp['types']) && $type == 'department') {
                        $referentialLocation->setName($comp['long_name']);
                        $referentialLocation->setSlug($this->slugify($comp['long_name']));
                    }


                    if ( in_array('postal_code', $comp['types']) && $city) {
                        $referentialLocation->setPostalCode($comp['long_name']);
                    } else {
                        $referentialLocation->setPostalCode($postalCode);
                    }


                    $referentialLocation->setDepartment($region);

                }


                $referentialLocation->setLocation($values['results'][0]);

                if (isset($values['results'][0]['geometry']['location'])) {
                    $referentialLocation->setLatitude($values['results'][0]['geometry']['location']['lat']);
                    $referentialLocation->setLongitude($values['results'][0]['geometry']['location']['lng']);
                }

                try{
                    $this->getContainer()->get('doctrine')->resetManager();
                    $this->getContainer()->get('doctrine')->getManager()->persist($referentialLocation);
                    $this->getContainer()->get('doctrine')->getManager()->flush();

                    $output->writeln($referentialLocation->getSlug() . ': institution Location  - OK');

                }
                catch (UniqueConstraintViolationException $e){
                    $output->writeln($referentialLocation->getSlug() . ': Error institution  - Duplicate values');
                }
                catch (NotNullConstraintViolationException $e) {
                    $output->writeln($referentialLocation->getSlug() . ': Error institution  - Not null values' . $e->getMessage());
                }
            }


            sleep(2);

        }
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

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
