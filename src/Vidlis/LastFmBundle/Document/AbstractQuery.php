<?php
namespace Vidlis\LastFmBundle\Document;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * Class AbstractQuery
 * @package Vidlis\LastFmBundle\Document
 */
abstract class AbstractQuery
{
    protected $queryBuilder;

    private $dm;

    /**
     * @param DocumentManager $documentManager
     * @param $document
     */
    protected function __construct(DocumentManager $documentManager, $document)
    {
        $this->queryBuilder = $documentManager->createQueryBuilder($document);
        $this->dm = $documentManager;
    }

    /**
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    /**
     * @return array|null|object
     */
    public function getSingle()
    {
        return $this->queryBuilder
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->queryBuilder
            ->getQuery()
            ->execute();
    }

    /**
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function addOrderBy($column, $direction = 'ASC')
    {
        $this->queryBuilder->sort($column, $direction);
        return $this;
    }

    /**
     * @param $limit
     * @param $offset
     * @return $this
     */
    public function setLimit($limit, $offset = 0)
    {
        $this->queryBuilder->limit($limit)->skip($offset);
        return $this;
    }

    public function persist($entity)
    {
        $this->dm->persist($entity);
        $this->dm->flush();
    }

    public function remove($entity)
    {
        $this->dm->remove($entity);
        $this->dm->flush();
    }
}

