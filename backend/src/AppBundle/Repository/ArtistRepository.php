<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ArtistRepository extends EntityRepository
{
    /**
     * @param $limit
     * @param $offset
     *
     * @return Paginator
     */
    public function findArtists($limit, $offset)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('a')
            ->andWhere('a.disabled = :disabled')->setParameter('disabled', false)
            ->join("a.albums", 'al')
            ->orderBy('a.name', 'ASC');

        $paginator = new Paginator($qb);

        $paginator->getQuery()
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $paginator;
    }
}
