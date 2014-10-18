<?php
namespace Vidlis\LastFmBundle\Document;

use Doctrine\ODM\MongoDB\DocumentManager;

abstract class AbstractQuery
{
    protected $queryBuilder;

    private $dm;

    protected function __construct(DocumentManager $documentManager, $document)
    {
        $this->queryBuilder = $documentManager->createQueryBuilder($document);
        $this->dm = $documentManager;
    }
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    public function getSingle()
    {
        return $this->queryBuilder
            ->getQuery()
            ->getSingleResult();
    }

    public function getList()
    {
        return $this->queryBuilder
            ->getQuery()
            ->execute();
    }

    public function setLimit($limit)
    {
        $this->queryBuilder->limit($limit);
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

