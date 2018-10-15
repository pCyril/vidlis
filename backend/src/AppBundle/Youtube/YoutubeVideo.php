<?php
namespace AppBundle\Youtube;

use AppBundle\Memcache\MemcacheService;
use GuzzleHttp\Client;
use Monolog\Logger;

class YoutubeVideo {
    
    private $url = 'https://www.googleapis.com/youtube/v3/videos?';
    
    private $key;
    
    private $part = 'snippet,contentDetails,statistics';
    
    private $id;

    /**
     * @var MemcacheService
     */
    private $memcacheService;

    /**
     * @var Logger
     */
    private $logger;
    
    public function __construct($memcacheService, $apiKey, $logger)
    {
        $this->key = $apiKey;
        $this->memcacheService = $memcacheService;
        $this->logger = $logger;
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

    /**
     * @return mixed
     */
    public function getResult()
    {
        $result = $this->memcacheService->get($this->id);
        if (!$result || empty($result)) {
            $client = new Client();
            try {
                $request = $client->request('GET', $this->getUrlSearch());
                $result = json_decode($request->getBody()->__toString(), true);
                $this->memcacheService->set($this->id, $result, 10800);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $result = [];
            }
        }

        return $result;
    }
}
