<?php
namespace Vidlis\LastFmBundle\LastFm;


abstract class LastFmAbstract{

    const BASE_URL = 'http://ws.audioscrobbler.com/2.0/?';

    private $key;

    private $memcacheService;

    private $lang = 'fr';

    private $format = 'json';

    /**
     * Params that will construct url
     * @var array
     */
    private $params = array();

    public function __construct($memcacheService, $apiKey)
    {
        $this->key = $apiKey;
        $this->memcacheService = $memcacheService;
        $this->addParam('lang', $this->lang);
        $this->addParam('format', $this->format);
        $this->addParam('api_key', $this->key);
    }


    public function getResults()
    {
        $key = 'key_cache'.implode('_', $this->params);
        $result = $this->memcacheService->get($key);
        if (!$result) {
            $result = json_decode(file_get_contents($this->getUrl()));
            $this->memcacheService->set($key, $result, 86600);
        }
        return $result;
    }

    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function getUrl()
    {
        $url = self::BASE_URL;
        foreach ($this->params as $key => $value) {
            $url .= $key . '=' . urlencode($value).'&';
        }
        return $url;
    }
}

