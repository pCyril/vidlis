<?php

namespace Vidlis\CoreBundle\Youtube;

use Vidlis\CoreBundle\Memcache\MemcacheService;

class YoutubePlaylist {

    private $url = 'https://www.googleapis.com/youtube/v3/search?';

    private $key = 'AIzaSyBhuf4T4RqCLlirmGfMNPlwGgq0uzRdH2M';

    private $part = 'snippet';

    private $maxResults = 50;

    private $id;

    private $memcache_active;

    public function __construct($playlistId, $memcache_active) {
        $this->id = urlencode($playlistId);
        $this->memcache_active = $memcache_active;
    }

    public function getUrlPlaylist()
    {
        $url = $this->url.'part='.$this->part
            .'&maxResults='.$this->maxResults
            .'&id='.$this->id
            .'&key='.$this->key;

        return $url;
    }

    public function getResults()
    {
        $memcache = new MemcacheService($this->memcache_active);
        $key = 'playlistId_'.$this->playlistId;
        $result = $memcache->get($key);
        if (!$result) {
            $result = json_decode(file_get_contents($this->getUrlPlaylist()));
            $memcache->set($key, $result, 1500);
        }
        return $result;
    }

    public function getSingleResult(){
        $results = $this->getResults();
        return $results->items[0];
    }
}

