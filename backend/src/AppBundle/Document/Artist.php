<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Artist {

    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @MongoDB\EmbedMany(targetDocument="Album")
     */
    private $albums = array();

    /**
     * @MongoDB\Field(type="string")
     */
    private $info;

    /**
     * @MongoDB\EmbedMany(targetDocument="Tag")
     */
    private $tags = array();

    /**
     * @MongoDB\Boolean
     */
    private $processed = false;

    /**
     * @MongoDB\Boolean
     */
    private $disabled = false;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $info
     * @return $this
     */
    public function setInfo($info)
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param Album $album
     * @return $this
     */
    public function addAlbum(Album $album)
    {
        foreach ($this->albums as $albumAlready) {
            if ($albumAlready->getMbid() == $album->getMbid()) {
                return $this;
            }
        }
        $this->albums[] = $album;
        return $this;
    }

    /**
     * @return Album[]
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param Tag $tag
     * @return $this
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * @return Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return $this
     */
    public function setProcessed()
    {
        $this->processed = true;
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
     * @return bool
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return $this
     */
    public function setDisabled()
    {
        $this->disabled = true;
        return $this;
    }


    public function getImagesPresentation($nbImageMax = 4)
    {
        $images = array();
        $nbImages = 1;
        foreach ($this->albums as $album) {
            if ($nbImages <= $nbImageMax) {
                if ($album->getImage() != '') {
                    $images[] = $album->getImage();
                }
            } else {
                break;
            }
            $nbImages++;
        }
        return $images;
    }

}
