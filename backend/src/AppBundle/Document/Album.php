<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use AppBundle\Document\Track;

/**
 * @MongoDB\EmbeddedDocument
 */
class Album {

    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @MongoDB\Field(type="string")
     */
    private $mbid;

    /**
     * @MongoDB\EmbedMany(targetDocument="Track")
     */
    private $tracks = array();

    /**
     * @MongoDB\Field(type="string")
     */
    private $releaseDate;

    /**
     * @MongoDB\Field(type="string")
     */
    private $image;

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
     * @param $mbid
     * @return $this
     */
    public function setMbid($mbid)
    {
        $this->mbid = $mbid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMbid()
    {
        return $this->mbid;
    }

    /**
     * @param Track $track
     * @return $this
     */
    public function addTrack(Track $track)
    {
        $this->tracks[] = $track;
        return $this;
    }

    /**
     * @param $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return Track[]
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

}