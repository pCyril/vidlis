<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityManager;

abstract class AbstractCache
{
    private $cacheDriver;

    protected function __construct(EntityManager $entityManager)
    {
        $this->cacheDriver = $entityManager->getConfiguration()->getResultCacheImpl();
    }

    /**
     * @param mixed String|Array $mixed
     * @return $this
     */
    public function deleteKeyCache($mixed)
    {
        if (is_array($mixed)) {
            foreach ($mixed as $key) {
                $this->cacheDriver->delete($key);
            }
        } else {
            $this->cacheDriver->delete($mixed);
        }
        return $this;
    }
}
