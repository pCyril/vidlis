<?php
namespace AppBundle\LastFm;


use GuzzleHttp\Client;
use Monolog\Logger;

abstract class LastFmAbstract{

    const BASE_URL = 'http://ws.audioscrobbler.com/2.0/?';

    private $key;

    private $memcacheService;

    private $lang = 'fr';

    private $format = 'json';

    /** @var  Logger */
    private $logger;

    /**
     * Params that will construct url
     * @var array
     */
    private $params = array();

    public function __construct($memcacheService, $apiKey, $logger)
    {
        $this->memcacheService = $memcacheService;
        $this->key = $apiKey;
        $this->logger = $logger;
        $this->addParam('lang', $this->lang);
        $this->addParam('format', $this->format);
        $this->addParam('api_key', $this->key);
    }


    public function getResults()
    {
        $key = 'key_cache'.implode('_', $this->params);
        $result = $this->memcacheService->get($key);
        if (!$result) {
            $client = new Client();
            try {
                $request = $client->request('GET', $this->getUrl());
                $result = json_decode($request->getBody()->__toString(), true);
                $this->memcacheService->set($key, $result, 86600);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $result = [];
            }
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

