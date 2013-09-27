<?php

namespace Mybands\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Playlist {

    protected $id;
    protected $name;
    protected $description;
    protected $category;
    protected $private;

    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getName() 
    {
        return $this->name;
    }

    public function setName($name) 
    {
        $this->name = $name;
    }

    public function getDescription() 
    {
        return $this->description;
    }

    public function setDescription($description) 
    {
        $this->description = $description;
    }

    public function getCategory() 
    {
        return $this->category;
    }

    public function setCategory($category) 
    {
        $this->category = $category;
    }

    public function isPrivate() 
    {
        return $this->private;
    }

    public function setPrivate($private) 
    {
        $this->private = $private;
    }

}