<?php
namespace AppBundle\LastFm\Album;

use AppBundle\LastFm\LastFmAbstract;

class Info extends LastFmAbstract {

    private $method = 'album.getinfo';

    /**
     * (Required)
     * The artist name
     * @var null
     */
    private $artist = null;

    /**
     * Required
     * The album name
     * @var null
     */
    private $album = null;

    /**
     * @var null
     */
    private $mbid = null;


    public function __construct($memcacheService, $apiKey, $logger) {
        $this->addParam('method', $this->method);
        parent::__construct($memcacheService, $apiKey, $logger);
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

    /**
     * @param $album
     * @return $this
     */
    public function setAlbum($album)
    {
        $this->album = $album;
        $this->addParam('album', $album);
        return $this;
    }

    /**
     * @param string $mbid
     * @return $this
     */
    public function setMbid($mbid)
    {
        $this->mbid = $mbid;
        $this->addParam('mbid', $mbid);
        return $this;
    }

}
