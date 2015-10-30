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
     * @param $userName
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllPlayListsByUserName($userName)
    {
        return $this->queryBuilder
            ->andWhere('u.username = :userName')
            ->setParameter('userName', $userName);
    }


    /**
     * @param $id
     * @param $userName
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findPlayListByIdAndUserName($id, $userName)
    {
        return $this->queryBuilder
            ->andWhere('u.username = :userName')
            ->andWhere('p.id= :playlistId')
            ->setParameter('userName', $userName)
            ->setParameter('playlistId', $id);
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

    /**
     * @param $private
     * @return $this
     */
    public function setPrivate($private)
    {
        $this->queryBuilder->andWhere('p.private = :private')
            ->setParameter('private', $private);
        return $this;
    }

    /**
     * @param Playlist $entity
     */
    public  function prePersist($entity)
    {
        $this->deleteKeyCache('playlist_all');
        $this->deleteKeyCache('playlist_unprivate');
        $this->deleteKeyCache('playlist_'.$entity->getId());
    }

    /**
     * @param Playlist $entity
     */
    public function preRemove($entity)
    {
        $this->deleteKeyCache('playlist_all');
        $this->deleteKeyCache('playlist_unprivate');
        $this->deleteKeyCache('playlist_'.$entity->getId());
    }
}
