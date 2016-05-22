<?php

namespace InstitutionBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InstitutionLocationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('institution:location')
            ->setDescription('Fix : Convertir les institutions en location')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $repository = $this->getContainer()->get('doctrine')->getRepository('InstitutionBundle:Institution');
        
        $institutions = $repository->findAll();
        
        foreach ($institutions as $institution) {

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

        }


        $this->getContainer()->get('doctrine')->getManager()->flush();

        $this->getContainer()->get('doctrine')->resetManager();
    }

}
