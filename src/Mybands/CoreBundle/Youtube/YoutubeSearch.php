<?php

namespace MyBands\CoreBundle\Youtube;

class YoutubeSearch {
    
    private $url = 'https://www.googleapis.com/youtube/v3/search?';
    
    private $key = 'AIzaSyBhuf4T4RqCLlirmGfMNPlwGgq0uzRdH2M';
    
    private $part = 'snippet';
    
    private $maxResults = 50;
    
    private $q;
    
    private $regionCode;
    
    private $type = 'video';
    
    public function __construct($search) {
        $this->q = urlencode($search);
        $this->regionCode = 'FR';
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
        $result = json_decode(file_get_contents($this->getUrlSearch()));
        return $result;
    }
}

