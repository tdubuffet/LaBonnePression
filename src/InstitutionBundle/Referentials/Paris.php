<?php
/**
 * Created by PhpStorm.
 * User: DUBUFFET
 * Date: 21/05/2016
 * Time: 18:37
 */

namespace InstitutionBundle\Referentials;


class Paris
{

    private $district = [
        1 => [
            'Saint-Germain-l\'Auxerrois',
            'Halles',
            'Palais-Royal',
            'Place-Vendôme',
        ],
        2 => [
            'Gaillon',
            'Vivienne',
            'Mail',
            'Bonne-Nouvelle'
        ],
        3 => [
            'Arts-et-Métiers',
            'Enfants-Rouges',
            'Archives',
            'Sainte-Avoye'
        ],
        4 => [
            'Saint-Merri',
            'Saint-Gervais',
            'Arsenal',
            'Notre-Dame'
        ],
        5 => [
            'Saint-Victor',
            'Jardin-des-Plantes',
            'Val-de-Grâce',
            'Sorbonne'
        ],
        6 => [
            'Monnaie',
            'Odéon',
            'Notre-Dame-des-Champs',
            'Saint-Germain-des-Prés'
        ],
        7 => [
            'Saint-Thomas-d\'Aquin',
            'Invalides',
            'École-Militaire',
            'Gros-Caillou'
        ],
        8 => [
            'Champs-Élysées',
            'Faubourg-du-Roule',
            'Madeleine',
            'Europe'
        ],
        9 => [
            'Saint-Georges',
            'Chaussée-d\'Antin',
            'Faubourg-Montmartre',
            'Rochechouart'
        ],
        10 => [
            'Saint-Vincent-de-Paul',
            'Porte-Saint-Denis',
            'Porte-Saint-Martin',
            'Hôpital-Saint-Louis'
        ],
        11 => [
            'Folie-Méricourt',
            'Saint-Ambroise',
            'Roquette',
            'Sainte-Marguerite'
        ],
        12 => [
            'Bel-Air',
            'Picpus',
            'Quinze-Vingts',
            'Bercy'
        ],
        13 => [
            'Salpêtrière',
            'Gare',
            'Maison-Blanche',
            'Croulebarbe'
        ],
        14 => [
            'Montparnasse',
            'Parc-de-Montsouris',
            'Petit-Montrouge',
            'Plaisance'
        ],
        15 => [
            'Saint-Lambert',
            'Necker',
            'Grenelle',
            'Javel'
        ],
        16 => [
            'Auteuil',
            'Muette',
            'Porte-Dauphine',
            'Chaillot'
        ],
        17 => [
            'Ternes',
            'Plaine-de-Monceaux',
            'Batignolles',
            'Épinettes'
        ],
        18 => [
            'Grandes-Carrières',
            'Clignancourt',
            'Goutte-d\'Or',
            'Chapelle'
        ],
        19 => [
            'Villette',
            'Pont-de-Flandre',
            'Amérique',
            'Combat'
        ],
        20 => [
            'Belleville',
            'Saint-Fargeau',
            'Père-Lachaise',
            'Charonne'
        ]
    ];

    /**
     * @return array
     */
    public function getDistrict()
    {
        return $this->district;
    }

}