<?php

namespace MyBands\CoreBundle\Youtube;

class YoutubeVideo {
    
    private $url = 'https://www.googleapis.com/youtube/v3/videos?';
    
    private $key = 'AIzaSyBhuf4T4RqCLlirmGfMNPlwGgq0uzRdH2M';
    
    private $part = 'snippet,contentDetails,statistics';
    
    private $id;
    
    public function __construct($id) {
        $this->id = $id;
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
        $result = json_decode(file_get_contents($this->getUrlSearch()));
        return $result;
    }
}
