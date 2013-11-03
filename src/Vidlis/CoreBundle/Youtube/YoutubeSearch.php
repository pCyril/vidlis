<?php

namespace Vidlis\CoreBundle\Youtube;

use Vidlis\CoreBundle\Memcache\MemcacheService;

class YoutubeSearch {
    
    private $url = 'https://www.googleapis.com/youtube/v3/search?';
    
    private $key = 'AIzaSyBhuf4T4RqCLlirmGfMNPlwGgq0uzRdH2M';
    
    private $part = 'snippet';
    
    private $maxResults = 50;
    
    private $q;
    
    private $regionCode;
    
    private $type = 'video';
    
    private $memcache_active;
    
    public function __construct($search, $memcache_active) {
        $this->q = urlencode($search);
        $this->regionCode = 'FR';
        $this->memcache_active = $memcache_active;
    }
    
    public function getUrlSearch() 
    {
        $url = $this->url.'part='.$this->part
               .'&type='.$this->type
               .'&maxResults='.$this->maxResults
               .'&q='.$this->q
               .'&regionCode='.$this->regionCode
               .'&key='.$this->key;
        
        return $url;
    }
    
    public function getResults()
    {
        $memcache = new MemcacheService($this->memcache_active);
        $result = $memcache->get($this->q);
        if (!$result) {
            $result = json_decode(file_get_contents($this->getUrlSearch()));
            $memcache->set($this->q, $result, 900);
        }
        return $result;
    }
}

