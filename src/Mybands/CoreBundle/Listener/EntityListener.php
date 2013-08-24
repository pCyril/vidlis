<?php

namespace Mybands\CoreBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;

class EntityListener
{
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        $postLoadFunction = strtolower($this->get_class_without_namespace($entity)).'PostLoad';
        if (method_exists($this, $postLoadFunction)) {
            $this->$postLoadFunction($entity, $entityManager);
        }
    }
    
    function get_class_without_namespace($obj) 
    {
        $classname = get_class($obj);
        if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
            $classname = $matches[1];
        }
        return $classname;
    }
    
    public function albumPostLoad($entity, $em)
    {
        $repoTitle = $em->getRepository('MyBandsCoreBundle:Title');
        $entity->setTitles($repoTitle->findBy(array('idAlbum' => $entity->getId())));
        $repoArtist = $em->getRepository('MyBandsCoreBundle:Artist');
        $entity->setArtist($repoArtist->findById($entity->getIdBand()));
    }
}
