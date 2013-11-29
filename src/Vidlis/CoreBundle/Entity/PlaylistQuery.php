<?php
namespace Vidlis\CoreBundle\Entity;

use Doctrine\ORM\EntityManager;
use Vidlis\CoreBundle\Entity\AbstractQuery;

class PlaylistQuery extends AbstractQuery
{
    private $unreadQueryBuilder;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);

        $this->unreadQueryBuilder = $entityManager->createQueryBuilder();

        $this->cacheResults(true);

        $this->queryBuilder
            ->select('p', 'pI', 'u')
            ->from('VidlisCoreBundle:Playlist', 'p')
            ->leftJoin('p.items', 'pI')
            ->leftJoin('p.user', 'u');
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->queryBuilder->andWhere('p.id = :playlistId')
            ->setParameter('playlistId', $id);
        return $this;
    }

    public function setPrivate($private)
    {
        $this->queryBuilder->andWhere('p.private = :private')
            ->setParameter('private', $private);
        return $this;
    }

    public  function prePersist($entity)
    {
        $this->deleteKeyCache('playlist_all');
        $this->deleteKeyCache('playlist_unprivate');
        $this->deleteKeyCache('playlist_'.$entity->getId());
    }

    public function preRemove($entity)
    {
        $this->deleteKeyCache('playlist_all');
        $this->deleteKeyCache('playlist_unprivate');
        $this->deleteKeyCache('playlist_'.$entity->getId());
    }
}
