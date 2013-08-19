<?php

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="album")
 * @ORM\Entity(repositoryClass="MyBands\CoreBundle\Entity\AlbumRepository")
 */
class Album 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\Column(name="name", type="DateTime")
     */
    private $dateOut;
    
    /**
     * @ORM\Column(name="name", type="text")
     */
    private $description;
    
    /**
     * @ORM\Column(name="name", type="string", length=200)
     */
    private $picture;
    
    /**
     * @ORM\Column(name="name", type="integer")
     */
    private $idBand;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDateOut() {
        return $this->dateOut;
    }

    public function setDateOut($dateOut) {
        $this->dateOut = $dateOut;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getPicture() {
        return $this->picture;
    }

    public function setPicture($picture) {
        $this->picture = $picture;
    }

    public function getIdBand() {
        return $this->idBand;
    }

    public function setIdBand($idBand) {
        $this->idBand = $idBand;
    }


    
}