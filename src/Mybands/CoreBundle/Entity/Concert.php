<?php
namespace Mybands\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="concert")
 * @ORM\Entity(repositoryClass="Mybands\CoreBundle\Entity\ConcertRepository")
 */
class Concert 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(name="name", type="string", length=200)
     */
    private $name;
    
    /**
     * @ORM\Column(name="address", type="string", length=200)
     */
    private $address;
    
    /**
     * @ORM\Column(name="zipCode", type="string", length=10)
     */
    private $zipCode;
    
    /**
     * @ORM\Column(name="city", type="string", length=200)
     */
    private $city;
    
    /**
     * @ORM\Column(name="salle", type="string", length=100)
     */
    private $salle;
    
    /**
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @ORM\Column(name="picture", type="string", length=200)
     */
    private $picture;
    
    
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

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getZipCode() {
        return $this->zipCode;
    }

    public function setZipCode($zipCode) {
        $this->zipCode = $zipCode;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getSalle() {
        return $this->salle;
    }

    public function setSalle($salle) {
        $this->salle = $salle;
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

}
