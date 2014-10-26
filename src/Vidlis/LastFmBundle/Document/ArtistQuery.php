<?php
namespace Vidlis\LastFmBundle\Document;

use Doctrine\ODM\MongoDB\DocumentManager;
use Vidlis\LastFmBundle\Document\AbstractQuery;

class ArtistQuery extends AbstractQuery
{

    /**
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager, 'VidlisLastFmBundle:Artist');
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->queryBuilder->field('name')->equals($name);
        return $this;
    }

    /**
     * @return $this
     */
    public function isProcessed()
    {
        $this->queryBuilder->field('processed')->equals(true);
        return $this;
    }

    /**
     * @return $this
     */
    public function isNotDisabled()
    {
        $this->queryBuilder->field('disabled')->notEqual(true);
        return $this;
    }

    /**
     * @return $this
     */
    public function notProcessed()
    {
        $this->queryBuilder->field('processed')->notEqual(true);
        return $this;
    }

    /**
     * @param $tagName
     * @return $this
     */
    public function addTag($tagName)
    {
        $this->queryBuilder->field('tags.name')->equals(strtolower($tagName));
        return $this;
    }

    public  function prePersist($entity)
    {
    }

    public function preRemove($entity)
    {
    }
}
