<?php

namespace Mybands\CoreBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;

class EntityListener
{
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

    }
    
}
