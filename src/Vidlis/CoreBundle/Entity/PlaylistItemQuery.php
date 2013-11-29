<?php
namespace Vidlis\CoreBundle\Entity;

use Doctrine\ORM\EntityManager;
use Vidlis\CoreBundle\Entity\AbstractQuery;

class PlaylistItemQuery extends AbstractQuery
{
    private $unreadQueryBuilder;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);

        $this->unreadQueryBuilder = $entityManager->createQueryBuilder();

        $this->cacheResults(true);

        $this->queryBuilder
            ->select('pI')
            ->from('VidlisCoreBundle:PlaylistItem', 'pI');
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->queryBuilder->andWhere('pI.id = :playlistItemId')
            ->setParameter('playlistItemId', $id);
        return $this;
    }

    public  function prePersist($entity)
    {
        $this->deleteKeyCache('playlistItem_'.$entity->getId());
    }

    public function preRemove($entity)
    {
        $this->deleteKeyCache('playlistItem_'.$entity->getId());
    }
}
