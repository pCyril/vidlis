<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="artists")
 * @ORM\Entity()
 */
class Artist
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var ArrayCollection
     */
    private $albums;

    /**
     * @ORM\Column(name="information", type="text")
     */
    private $information;

    /**
     * @var ArrayCollection
     */
    private $tags;

    /**
     * @var bool
     */
    private $processed = false;

    /**
     * @var bool
     */
    private $disabled = false;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $album
     * @return $this
     */
    public function addAlbum($album)
    {
        $this->albums->add($album);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param $tag
     * @return $this
     */
    public function addTags($tag)
    {
        $this->tags->add($tag);

        return $this;
    }

    /**
     * @param $processed
     *
     * @return $this
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;

        return $this;
    }

    /**
     * @return bool
     */
    public function isProcessed()
    {
        return $this->processed;
    }

    /**
     * @param $disabled
     * @return $this
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled;
    }
}
