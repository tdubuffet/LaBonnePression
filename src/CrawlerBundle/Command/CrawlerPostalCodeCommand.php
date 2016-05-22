<?php

namespace CrawlerBundle\Command;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use InstitutionBundle\Entity\Institution;
use InstitutionBundle\Entity\ReferentialCity;
use InstitutionBundle\Referentials\Paris;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlerPostalCodeCommand extends ContainerAwareCommand
{

    protected $google;

    protected function configure()
    {
        $this
            ->setName('crawler:import:postalcode')
            ->setDescription('Importer toutes les codes postaux en france')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $institutionRepositoy = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository('InstitutionBundle:Institution');


        $areaAuthorized = [75, 77, 78, 91, 92, 93, 94, 95];

        if (($handle = fopen(__DIR__ . '/../Resources/csv/postalCode.csv', "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

                $region = substr($data[2], 0, 2);
                if (in_array($region, $areaAuthorized)) {
                    var_dump($data);

                    $city = new ReferentialCity();
                    $city->setPostalCode($data[2]);
                    $city->setCity($data[3]);

                    $this->getContainer()->get('doctrine')->getManager()->persist($city);
                }

            }
            fclose($handle);
        }



        $this->getContainer()->get('doctrine')->getManager()->flush();



    }
}
