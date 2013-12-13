<?php
namespace Vidlis\CoreBundle\Youtube;


class YoutubeSuggestion {

    private $url = 'https://www.googleapis.com/youtube/v3/search?';

    private $key;

    private $part = 'snippet';

    private $maxResults = 10;

    private $relatedToVideoId;

    private $regionCode;

    private $type = 'video';

    private $memcacheService;

    public function __construct($memcacheService, $apiKey)
    {
        $this->key = $apiKey;
        $this->regionCode = 'FR';
        $this->memcacheService = $memcacheService;
    }

    public function setRelatedToVideoId($id)
    {
        $this->relatedToVideoId = $id;
        return $this;
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
        $key = 'relatedToVideoId_'.$this->relatedToVideoId;
        $result = $this->memcacheService->get($key);
        if (!$result) {
            $result = json_decode(file_get_contents($this->getUrlSuggestion()));
            $this->memcacheService->set($key, $result, 1500);
        }
        return $result;
    }
}

