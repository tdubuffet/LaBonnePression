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
            ->setName('institution:category:populate')
            ->setDescription('Ajoutes les catégories')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository('InstitutionBundle:Category');

        $categories = [
            'Bar à cocktails'   => '  indépendant  ou  intégré  dans  un  hôtel.  Lieu  confortable,  intime, cadre luxueux. C’est le palace des bars, idéal pour recevoir la clientèle internationale de tourisme et d’affaires. Toutes les boissons françaises et étrangères y sont servies et l’on trouve un grand choix de cocktails classiques et innovants.',
            'Bar d’hôtel'       => 'on le rencontre dans les hôtels de luxe. Il répond à l’attente d’une clientèle cosmopolite et  aisée.  Il  assure  le  service  des  boissons  dans  les étages, les salons et les restaurants. Dans un même hôtel, plusieurs bars ayant chacun leur personnalité et leurs spécialités peuvent exister.',
            'Brasserie'         => '',
            'Bar de restaurant' => '',
            'Cabaret' => '',
            'Café' => '',
            'Cocktailerie' => '',
            'Rhumerie' => '',
            'Discothèque' => '',
            'Salon de thé' => '',
            'Piano-bar' => '',
            'Bar à vins' => '',
            'Pub' => ''
        ];


        $this->getContainer()->get('doctrine')->getManager()->flush();
        $this->getContainer()->get('doctrine')->resetManager();
    }

}
