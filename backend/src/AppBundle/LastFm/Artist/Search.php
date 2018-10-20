<?php
namespace AppBundle\LastFm\Artist;

use AppBundle\LastFm\LastFmAbstract;
class Search extends LastFmAbstract {

    private $method = 'artist.search';

    /**
     * (Optional)
     * The page number to fetch. Defaults to first page.
     * @var null
     */
    private $page = null;

    /**
     * (Required)
     * The artist name
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
     * @param $artist
     * @return $this
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
        $this->addParam('artist', $artist);
        return $this;
    }

}
