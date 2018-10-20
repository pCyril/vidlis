<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArtistRepository extends EntityRepository
{
    /**
     * @param $limit
     * @param $offset
     *
     * @return array
     */
    public function findArtists($limit, $offset)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('a')
            ->andWhere('a.disabled = :disabled')->setParameter('disabled', false)
            ->join("a.albums", 'al')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('a.name', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
