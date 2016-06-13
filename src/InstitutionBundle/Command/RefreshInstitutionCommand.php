<?php

namespace InstitutionBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshInstitutionCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('institution:refresh')
            ->setDescription('Fix : rafraichis tous les insitituions')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $repository = $this->getContainer()->get('doctrine')->getRepository('InstitutionBundle:Institution');
        
        $institutions = $repository->findAll();

        foreach ($institutions as $institution) {

            $institution->setSecretCode();

        }


        $this->getContainer()->get('doctrine')->getManager()->flush();

        $this->getContainer()->get('doctrine')->resetManager();
    }

}
