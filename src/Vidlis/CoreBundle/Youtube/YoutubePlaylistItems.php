<?php

namespace Vidlis\CoreBundle\Youtube;

use Vidlis\CoreBundle\Memcache\MemcacheService;

class YoutubePlaylistItems {

    private $url = 'https://www.googleapis.com/youtube/v3/search?';

    private $key = 'AIzaSyBhuf4T4RqCLlirmGfMNPlwGgq0uzRdH2M';

    private $part = 'snippet';

    private $maxResults = 50;

    private $playlistId;

    private $memcache_active;

    public function __construct($playlistId, $memcache_active) {
        $this->playlistId = urlencode($playlistId);
        $this->memcache_active = $memcache_active;
    }

    public function getUrlSuggestion()
    {
        $url = $this->url.'part='.$this->part
            .'&maxResults='.$this->maxResults
            .'&playlistId='.$this->playlistId
            .'&key='.$this->key;

        return $url;
    }

    public function getResults()
    {
        $memcache = new MemcacheService($this->memcache_active);
        $key = 'playlistId_'.$this->playlistId;
        $result = $memcache->get($key);
        if (!$result) {
            $result = json_decode(file_get_contents($this->getUrlSuggestion()));
            $memcache->set($key, $result, 1500);
        }
        return $result;
    }
}

