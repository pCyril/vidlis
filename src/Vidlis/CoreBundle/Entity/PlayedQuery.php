<?php
namespace Vidlis\CoreBundle\Entity;

use Doctrine\ORM\EntityManager;
use Vidlis\CoreBundle\Entity\AbstractQuery;

class PlayedQuery extends AbstractQuery
{
    private $unreadQueryBuilder;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);

        $this->unreadQueryBuilder = $entityManager->createQueryBuilder();

        $this->cacheResults(true);

        $this->queryBuilder
            ->select('p', 'pI', 'u')
            ->from('VidlisCoreBundle:Played', 'p');
    }

    public  function prePersist($entity)
    {
    }

    public function preRemove($entity)
    {
    }
}
