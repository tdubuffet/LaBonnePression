<?php

namespace InstitutionBundle\Repository;

/**
 * ReferentialLocationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReferentialLocationRepository extends \Doctrine\ORM\EntityRepository
{

    public function findByLikeName($q)
    {
        $qb = $this->createQueryBuilder('a')  //add select and array for JSON
        ->where('a.name LIKE \'%'.$q.'%\' OR a.postalCode LIKE \''.$q.'%\'')
        ->setMaxResults(20);

        return $qb->getQuery()
            ->getResult();
    }

}
