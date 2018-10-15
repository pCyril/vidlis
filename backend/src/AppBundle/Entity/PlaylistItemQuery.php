<?php
namespace AppBundle\Entity;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\AbstractQuery;
use AppBundle\Entity\PlaylistQuery;

class PlaylistItemQuery extends AbstractQuery
{
    private $unreadQueryBuilder;

    private $playlistQuery;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);

        $this->playlistQuery = new PlaylistQuery($entityManager);

        $this->unreadQueryBuilder = $entityManager->createQueryBuilder();

        $this->cacheResults(true);

        $this->queryBuilder
            ->select('pI')
            ->from('AppBundle:PlaylistItem', 'pI');
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

    /**
     * @param Playlistitem $entity
     */
    public  function prePersist($entity)
    {
        $this->deleteKeyCache('playlistItem_'.$entity->getId());
        $this->playlistQuery->preRemove($entity->getPlaylist());
    }

    /**
     * @param Playlistitem $entity
     */
    public function preRemove($entity)
    {
        $this->deleteKeyCache('playlistItem_'.$entity->getId());
        $this->playlistQuery->preRemove($entity->getPlaylist());
    }
}
