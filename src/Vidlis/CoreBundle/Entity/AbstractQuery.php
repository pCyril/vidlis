<?php
namespace Vidlis\CoreBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;

abstract class AbstractQuery extends AbstractCache
{
    protected $queryBuilder;

    private $cacheResults = false;

    private $lifetime = 84600;

    private  $em;

    protected function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
        $this->queryBuilder = $entityManager->createQueryBuilder();
        $this->em = $entityManager;
    }

    /**
     * @param $use
     */
    public function cacheResults($use)
    {
        $this->cacheResults = $use;
    }

    /**
     * @param $lifetime
     * @return $this
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;
        return $this;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @param $key
     * @return null|mixed
     */
    public function getSingle($key)
    {
        try {
            return $this->queryBuilder
                ->getQuery()
                ->useResultCache($this->cacheResults, $this->lifetime, $key)
                ->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    /**
     * @param $key
     * @return array
     */
    public function getList($key)
    {
        return $this->queryBuilder
            ->getQuery()
            ->useResultCache($this->cacheResults, $this->lifetime, $key)
            ->getResult();
    }

    /**
     * @param $entity
     */
    public function persist($entity)
    {
        $this->prePersist($entity);
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @param $entity
     */
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

    /**
     * @param $field
     * @return $this
     */
    public function addGroupBy($field)
    {
        $this->queryBuilder->addGroupBy($field);
        return $this;
    }

    /**
     * @param $number
     * @return $this
     */
    public function setLimit($number)
    {
        $this->queryBuilder->setMaxResults($number);
        return $this;
    }

    abstract public function prePersist($entity);

    abstract public function preRemove($entity);

}
