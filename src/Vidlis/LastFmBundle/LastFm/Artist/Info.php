<?php
namespace Vidlis\LastFmBundle\LastFm\Artist;

use Vidlis\LastFmBundle\LastFm\LastFmAbstract;
class Info extends LastFmAbstract {

    private $method = 'artist.getinfo';

    /**
     * (Required)
     * The artist name
     * @var null
     */
    private $artist = null;


    public function __construct($memcacheService, $apiKey) {
        $this->addParam('method', $this->method);
        parent::__construct($memcacheService, $apiKey);
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
