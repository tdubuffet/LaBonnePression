<?php

namespace InstitutionBundle\Repository;

/**
 * InstitutionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InstitutionRepository extends \Doctrine\ORM\EntityRepository
{

    public function countByPostalCode($postalCode)
    {

        $qb = $this->createQueryBuilder('a');
        $qb->select('COUNT(a) as nbr, AVG(a.googleRating) as rate, SUM(a.googleUserRatingsTotal) as nbrRate');
        $qb->where('a.postalCode = :postalCode');
        $qb->setParameter('postalCode', $postalCode);

        return $qb->getQuery()->getSingleResult();

    }

    public function countByDepartement($departmentCode)
    {

        $qb = $this->createQueryBuilder('a');
        $qb->select('COUNT(a) as nbr, AVG(a.googleRating) as rate, SUM(a.googleUserRatingsTotal) as nbrRate');
        $qb->where('SUBSTRING(a.postalCode,1,2) = :departementCode');
        $qb->setParameter('departementCode', $departmentCode);

        return $qb->getQuery()->getSingleResult();

    }

    public function getPopularCity($departementCode = null, $limit = 20)
    {

        $qb = $this->createQueryBuilder('a');
        $qb->select('COUNT(a) as nbr, AVG(a.googleRating) as rate, SUM(a.googleUserRatingsTotal) as nbrRate, a.city,SUBSTRING(a.postalCode,1,2), a.postalCode');
        $qb->where('SUBSTRING(a.postalCode,1,2) in (:postalCodesEnabled)');

        if ($departementCode) {

            $qb->setParameter('postalCodesEnabled', $departementCode);

        } else {

            $qb->setParameter('postalCodesEnabled', array(
                77, 78, 91, 92, 93, 94, 95
            ));

        }

        $qb->groupBy('a.city');
        $qb->orderBy('nbr', 'DESC');
        $qb->setMaxResults($limit);
    

        $query = $qb->getQuery();

        return $query->getResult();

    }

    public function getCitiesInIleDeFrance($limitByDepartment)
    {
        $departementsCode = [77, 78, 91, 92, 93, 94, 95];

        $data = [];
        foreach($departementsCode as $code) {
            $data[$code] = $this->getPopularCity($code, $limitByDepartment);
        }

        return $data;
    }

    public function countParisDisctrict()
    {
        $postalCode = [];
        for($i = 1; $i <= 20; $i++) {
            $postalCode[75000 + $i] = $this->countByPostalCode(75000 + $i);
        }

        return $postalCode;
    }

}
