<?php
namespace Vidlis\CoreBundle\Entity;

use Doctrine\ORM\EntityManager;
use Vidlis\CoreBundle\Entity\AbstractQuery;

class PlayedQuery extends AbstractQuery
{
    private $unreadQueryBuilder;

    private $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
        $this->em = $entityManager;
        $this->unreadQueryBuilder = $entityManager->createQueryBuilder();
        $this->cacheResults(true);
        $this->queryBuilder
            ->select('p')
            ->from('VidlisCoreBundle:Played', 'p');
    }

    /**
     * @param $limit
     * @return Played[]
     */
    public function getLastPlayed($limit)
    {
        $this->queryBuilder = $this->em->createQueryBuilder();
        $this->queryBuilder
            ->select('p', 'MAX(p.datePlayed) as dateMax')
            ->from('VidlisCoreBundle:Played', 'p')
            ->addGroupBy('p.idVideo')
            ->orderBy('dateMax', 'DESC');
        $this->setLimit($limit)
            ->setLifetime(30);
        return $this->getList('video_played');
    }

    public  function prePersist($entity)
    {
    }

    public function preRemove($entity)
    {
    }
}
