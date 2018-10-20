<?php
namespace AppBundle\LastFm\Track;

use AppBundle\LastFm\LastFmAbstract;

class Search extends LastFmAbstract {

    private $method = 'track.search';

    /**
     * (Optional)
     * The page number to fetch. Defaults to first page.
     * @var null
     */
    private $page = null;

    /**
     * (Required)
     * The track name
     * @var null
     */
    private $track = null;

    /**
     * (Optional)
     * Narrow your search by specifying an artist.
     * @var null
     */
    private $artist = null;

    /**
     * (Optional)
     * The number of results to fetch per page. Defaults to 30.
     * @var null
     */
    private $limit = 30;

    public function __construct($memcacheService, $apiKey, $logger) {
        $this->addParam('method', $this->method);
        parent::__construct($memcacheService, $apiKey, $logger);
    }

    /**
     * @param $page
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;
        $this->addParam('page', $page);
        return $this;
    }

    /**
     * @param $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        $this->addParam('limit', $limit);
        return $this;
    }

    /**
     * @param $track
     * @return $this
     */
    public function setTrack($track)
    {
        $this->track = $this->cleanSearchValue($track);
        $this->addParam('track', $this->track);
        return $this;
    }

    /**
     * @param $artist
     * @return $this
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
        $this->addParam('artist', $artist);
        return $this;
    }

    private function cleanSearchValue($value)
    {
        $value = preg_replace('#\((.+)\)#', null, $value);
        $value = preg_replace('#[(.+)]#', null, $value);
        return trim($value);

    }

}
