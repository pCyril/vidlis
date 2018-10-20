<?php
namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tracks")
 * @ORM\Entity()
 */
class Track
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(name="youtube_id", type="string", length=10, nullable=true)
     */
    private $youtubeId;

    /**
     * @var Album
     *
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="album")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id")
     */
    private $album;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
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

    /**
     * @return Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param Album $album
     *
     * @return $this
     */
    public function setAlbum($album)
    {
        $this->album = $album;

        return $this;
    }

}