<?php
namespace Vidlis\CoreBundle\Youtube;


class YoutubeVideo {
    
    private $url = 'https://www.googleapis.com/youtube/v3/videos?';
    
    private $key;
    
    private $part = 'snippet,contentDetails,statistics';
    
    private $id;
    
    private $memcacheService;
    
    public function __construct($memcacheService, $apiKey)
    {
        $this->key = $apiKey;
         $this->memcacheService = $memcacheService;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
        $result = $this->memcacheService->get($this->id);
        if (!$result) {
            $result = json_decode(file_get_contents($this->getUrlSearch()));
            $this->memcacheService->set($this->id, $result, 10800);
        }
        return $result;
    }
}
