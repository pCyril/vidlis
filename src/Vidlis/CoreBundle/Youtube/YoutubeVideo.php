<?php

namespace Vidlis\CoreBundle\Youtube;

use Vidlis\CoreBundle\Memcache\MemcacheService;

class YoutubeVideo {
    
    private $url = 'https://www.googleapis.com/youtube/v3/videos?';
    
    private $key = 'AIzaSyBhuf4T4RqCLlirmGfMNPlwGgq0uzRdH2M';
    
    private $part = 'snippet,contentDetails,statistics';
    
    private $id;
    
    private $memcache_active;
    
    public function __construct($id, $memcache_active) {
        $this->id = $id;
        $this->memcache_active = $memcache_active;
    }
    
    public function getUrlSearch() 
    {
        $url = $this->url.'part='.urlencode($this->part)
               .'&id='.$this->id
               .'&key='.$this->key;
        
        return $url;
    }
    
    public function getResult()
    {
        $memcache = new MemcacheService($this->memcache_active);
        $result = $memcache->get($this->id);
        if (!$result) {
            $result = json_decode(file_get_contents($this->getUrlSearch()));
            $memcache->set($this->id, $result, 3600);
        }
        return $result;
    }
}
