<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ArtistRepository extends EntityRepository
{
    /**
     * @param $gender
     * @param $limit
     * @param $offset
     *
     * @return Paginator
     */
    public function findArtists($gender, $limit, $offset)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('a')
            ->andWhere('a.disabled = :disabled')->setParameter('disabled', false)
            ->andWhere('a.processed = :processed')->setParameter('processed', true)
            ->join("a.albums", 'al')
            ->orderBy('a.name', 'ASC');

        if ($gender !== 'null' && $gender !== null && $gender !== 'all') {
            $qb->andWhere(
                $qb->expr()->like('lower(a.tags)', ':search')
            )->setParameter('search', '%' . strtolower($gender) . '%');
        }

        $paginator = new Paginator($qb);

        $paginator->getQuery()
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $paginator;
    }
}
