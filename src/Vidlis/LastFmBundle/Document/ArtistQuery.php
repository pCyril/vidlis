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

    /**
     * Return a similar list of artist on tag name
     * @param Artist $artist
     * @param int $limit
     * @return bool|mixed
     */
    public function getSimilarArtists(Artist $artist, $limit = 4)
    {
        $this->queryBuilder->field('name')->notEqual($artist->getName());
        $tags = $artist->getTags();
        if ($tags) {
            $tag = $tags[0];
            $this->addTag($tag->getName())
                ->isNotDisabled()
                ->isProcessed()
                ->setLimit($limit);
            return $this->getList();
        } else {
            return false;
        }
    }

    public  function prePersist($entity)
    {
    }

    public function preRemove($entity)
    {
    }
}
