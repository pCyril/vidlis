<?php
namespace AppBundle\Entity;

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
     * @return $this
     */
    public function cacheResults($use)
    {
        $this->cacheResults = $use;
        return $this;
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
    public function getSingle($key = null)
    {
        try {
            $query =  $this->queryBuilder->getQuery();
            if (null !== $key && $this->cacheResults) {
                $query->useResultCache($this->cacheResults, $this->lifetime, $key);
            }
            return $query->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    /**
     * @param $key
     * @return array
     */
    public function getList($key = null)
    {
        $query = $this->queryBuilder->getQuery();
        if (null !== $key && $this->cacheResults) {
            $query->useResultCache($this->cacheResults, $this->lifetime, $key);
        }

        return $query->getResult();
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
     * Example ['c.username' => 'DESC']
     * @param [] $orders
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
     * @param int $number
     * @param int $offset
     * @return $this
     */
    public function setLimit($number, $offset = 0)
    {
        $this->queryBuilder->setMaxResults($number)->setFirstResult($offset);
        return $this;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    abstract public function prePersist($entity);

    abstract public function preRemove($entity);

}
