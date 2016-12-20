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
        
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository('InstitutionBundle:Institution');
        
        $institutions = $repository->findBy(array('slug' => null), [], 1000, 0);
        foreach ($institutions as $institution) {
            $institution->setLittleDescription('Aucun description pour cet établissement');
            var_dump($institution->getSlug());

            $this->getContainer()->get('doctrine')->getManager()->persist($institution);
        }


        $this->getContainer()->get('doctrine')->getManager()->flush();
        $this->getContainer()->get('doctrine')->resetManager();
    }

}
