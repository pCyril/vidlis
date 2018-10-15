<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument
 */
class Track {

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
    private $youtubeId;

    /**
     * @MongoDB\Field(type="string")
     */
    private $duration;

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

    public function setYoutubeId($youtubeId)
    {
        $this->youtubeId = $youtubeId;
        return $this;
    }

    public function getYoutubeId()
    {
        return $this->youtubeId;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getHumanReadableDuration()
    {
        $duration = '';
        if ($this->duration != '') {
            $s = $this->duration%60;
            $s = str_pad($s, 2, 0, STR_PAD_LEFT);
            $m = floor(($this->duration%3600)/60);
            return "$m:$s";
        }
        return $duration;
    }

}