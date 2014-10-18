<?php
namespace Vidlis\LastFmBundle\Document;

use Doctrine\ODM\MongoDB\DocumentManager;
use Vidlis\LastFmBundle\Document\AbstractQuery;

class ArtistQuery extends AbstractQuery
{

    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager, 'VidlisLastFmBundle:Artist');
    }

    public function setName($name)
    {
        $this->queryBuilder->field('name')->equals($name);
        return $this;
    }

    public function notProcessed()
    {
        $this->queryBuilder->field('processed')->notEqual(true);
        return $this;
    }

    public  function prePersist($entity)
    {
    }

    public function preRemove($entity)
    {
    }
}
