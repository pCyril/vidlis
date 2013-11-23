<?php

namespace Vidlis\CoreBundle\Youtube;

use Vidlis\CoreBundle\Memcache\MemcacheService;

class YoutubeSuggestion {

    private $url = 'https://www.googleapis.com/youtube/v3/search?';

    private $key = 'AIzaSyBhuf4T4RqCLlirmGfMNPlwGgq0uzRdH2M';

    private $part = 'snippet';

    private $maxResults = 10;

    private $relatedToVideoId;

    private $regionCode;

    private $type = 'video';

    private $memcache_active;

    public function __construct($videoId, $memcache_active) {
        $this->relatedToVideoId = urlencode($videoId);
        $this->regionCode = 'FR';
        $this->memcache_active = $memcache_active;
    }

    public function getUrlSuggestion()
    {
        $url = $this->url.'part='.$this->part
            .'&type='.$this->type
            .'&maxResults='.$this->maxResults
            .'&relatedToVideoId='.$this->relatedToVideoId
            .'&regionCode='.$this->regionCode
            .'&key='.$this->key;

        return $url;
    }

    public function getResults()
    {
        $memcache = new MemcacheService($this->memcache_active);
        $key = 'relatedToVideoId_'.$this->relatedToVideoId;
        $result = $memcache->get($key);
        if (!$result) {
            $result = json_decode(file_get_contents($this->getUrlSuggestion()));
            $memcache->set($key, $result, 1500);
        }
        return $result;
    }
}

