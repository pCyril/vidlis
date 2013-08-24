<?php

namespace MyBands\CoreBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="band")
 * @ORM\Entity(repositoryClass="MyBands\CoreBundle\Entity\ArtistRepository")
 */
class Artist 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    
    /**
     * @ORM\Column(name="picture", type="string", length=200)
     */
    private $picture;
    
    /**
     * @ORM\Column(name="bio", type="text")
     */
    private $bio;
    
    /**
     * @ORM\Column(name="website", type="string", length=100)
     */
    private $website;
    
    /**
     * @ORM\Column(name="adminBand", type="integer")
     */
    private $bandAdmin;
    
    /**
     * @ORM\Column(name="urlBand", type="string", length=100)
     */
    private $urlBand;
    
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

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture) 
    {
        $this->picture = $picture;
    }

    public function getBio() 
    {
        return $this->bio;
    }

    public function setBio($bio) 
    {
        $this->bio = $bio;
    }

    public function getWebsite() 
    {
        return $this->website;
    }

    public function setWebsite($website) 
    {
        $this->website = $website;
    }

    public function getBandAdmin() 
    {
        return $this->bandAdmin;
    }

    public function setBandAdmin($bandAdmin) 
    {
        $this->bandAdmin = $bandAdmin;
    }

    public function getUrlBand() 
    {
        return $this->urlBand;
    }

    public function setUrlBand($urlBand) 
    {
        $this->urlBand = $urlBand;
    }
    
}
