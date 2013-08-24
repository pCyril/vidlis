<?php

namespace Mybands\CoreBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use MyBands\CoreBundle\Entity\Album;

class EntityListener
{
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof Album) {
            
        }
    }
}
