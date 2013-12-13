<?php
namespace Vidlis\CoreBundle\Youtube;


class YoutubePlaylistItems {

    private $url = 'https://www.googleapis.com/youtube/v3/playlistItems?';

    private $key;

    private $part = 'snippet';

    private $maxResults = 50;

    private $idPlaylist;

    private $memcacheService;

    public function __construct($memcacheService, $apiKey)
    {
        $this->key = $apiKey;
        $this->memcacheService = $memcacheService;
    }

    public function setIdPlaylist($idPlaylist)
    {
        $this->idPlaylist = urlencode($idPlaylist);
        return $this;
    }

    public function getUrlPlaylistItems()
    {
        $url = $this->url.'part='.$this->part
            .'&maxResults='.$this->maxResults
            .'&playlistId='.$this->idPlaylist
            .'&key='.$this->key;

        return $url;
    }

    public function getResults()
    {
        $key = 'playlistItemsId_'.$this->idPlaylist;
        $result = $this->memcacheService->get($key);
        if (!$result) {
            $result = json_decode(file_get_contents($this->getUrlPlaylistItems()));
            $this->memcacheService->set($key, $result, 1500);
        }
        return $result;
    }
}

