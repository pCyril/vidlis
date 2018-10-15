<?php
namespace AppBundle\Youtube;


class YoutubePlaylist {

    private $url = 'https://www.googleapis.com/youtube/v3/playlists?';

    private $key;

    private $part = 'snippet';

    private $maxResults = 50;

    private $id;

    private $memcacheService;

    public function __construct($memcacheService, $apiKey)
    {
        $this->key = $apiKey;
        $this->memcacheService = $memcacheService;
    }

    public function setId($id)
    {
        $this->id = urlencode($id);
        return $this;
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
        $key = 'playlistId_'.$this->playlistId;
        $result = $this->memcacheService->get($key);
        if (!$result) {
            $result = json_decode(file_get_contents($this->getUrlPlaylist()), true);
            $this->memcacheService->set($key, $result, 1500);
        }
        return $result;
    }

    public function getSingleResult(){
        $results = $this->getResults();
        return $results['items'][0];
    }
}

