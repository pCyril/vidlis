<?php

namespace AppBundle\Memcache;

class MemcacheService {

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var \Memcache
     */
    private $memcache;

    /**
     * MemcacheService constructor.
     * @param $active
     * @param $host
     * @param $port
     */
    public function __construct($active, $host, $port)
    {
        $this->active = $active;
        if ($active) {
            $this->memcache = new \Memcache;
            $this->memcache->connect($host, $port);
        }
    }

    public function get($key)
    {
        if ($this->active) {
            return $this->memcache->get($key);
        } else {
            return false;
        }
    }

    public function set($key, $data, $ttl = 300)
    {
        if ($this->active) {
            return $this->memcache->set($key, $data, false, $ttl);
        } else {
            return false;
        }
    }

    public function delete($key)
    {
        if ($this->active) {
            return $this->memcache->delete($key);
        } else {
            return false;
        }
    }

}