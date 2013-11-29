<?php

namespace Vidlis\CoreBundle\Entity;

use Doctrine\ORM\EntityManager;
use Vidlis\CoreBundle\Entity\AbstractCache;

abstract class AbstractQuery extends AbstractCache
{
    protected $queryBuilder;

    private $cacheResults = false;

    private $context;

    private $lifetime = 300;

    private $em;

    protected function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
        $this->queryBuilder = $entityManager->createQueryBuilder();
        $this->em = $entityManager;
    }

    public function cacheResults($use)
    {
        $this->cacheResults = $use;
    }

    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;
    }

    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    public function getSingle($key)
    {
        return $this->queryBuilder
            ->getQuery()
            ->useResultCache($this->cacheResults, $this->lifetime, $key)
            ->getSingleResult();
    }

    public function getList($key)
    {
        return $this->queryBuilder
            ->getQuery()
            ->useResultCache($this->cacheResults, $this->lifetime, $key)
            ->getResult();
    }

    public function persist($entity)
    {
        $this->prePersist($entity);
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function remove($entity)
    {
        $this->preRemove($entity);
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * Exemple array('c.username' => 'DESC')
     * @param array() $orders
     * @return $this
     */
    public function setOrderBy($orders)
    {
        foreach ($orders as $key => $value) {
            $this->queryBuilder->addOrderBy($key, $value);
        }
        return $this;
    }

    abstract public function prePersist($entity);

    abstract public function preRemove($entity);

}
