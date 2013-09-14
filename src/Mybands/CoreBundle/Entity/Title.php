<?php
namespace Mybands\CoreBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="title")
 * @ORM\Entity(repositoryClass="Mybands\CoreBundle\Entity\TitleRepository")
 */
class Title 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
 
    /**
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    
    /**
     *
     * @ORM\Column(name="order", type="integer")
     */
    private $order;
    
    /**
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;
    
    /**
     *
     * @ORM\Column(name="pathMp3", type="string", length=100)
     */
    private $pathMp3;
    
    /**
     *
     * @ORM\Column(name="idAlbum", type="integer")
     */
    private $idAlbum;
    
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

    public function getOrder() {
        return $this->order;
    }

    public function setOrder($order) {
        $this->order = $order;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
    }

    public function getPathMp3() {
        return $this->pathMp3;
    }

    public function setPathMp3($pathMp3) {
        $this->pathMp3 = $pathMp3;
    }

    public function getIdAlbum() {
        return $this->idAlbum;
    }

    public function setIdAlbum($idAlbum) {
        $this->idAlbum = $idAlbum;
    }


    
}