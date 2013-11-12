<?php
namespace Vidlis\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vidlis\CoreBundle\Youtube\YoutubeVideo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="playlistitem")
 */
class Playlistitem
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $idVideo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $videoName;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $videoDuration;

    /**
     * @ORM\ManyToOne(targetEntity="Playlist", inversedBy="items", cascade={"remove"})
     * @ORM\JoinColumn(name="idPlaylist", referencedColumnName="id")
     */
    private $playlist;

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
     * @param mixed $idPlaylist
     */
    public function setPlaylist($playlist)
    {
        $this->playlist = $playlist;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlaylist()
    {
        return $this->playlist;
    }

    /**
     * @param mixed $idVideo
     */
    public function setIdVideo($idVideo)
    {
        $this->idVideo = $idVideo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdVideo()
    {
        return $this->idVideo;
    }

    public function getVideoName()
    {
        return $this->videoName;
    }

    public function setVideoName($videoName)
    {
        $this->videoName = $videoName;
        return $this;
    }

    public function getVideoDuration()
    {
        $this->videoDuration = substr($this->videoDuration, 2);
        $minutes = substr($this->videoDuration, 0, strpos($this->videoDuration, 'M'));
        $secondes = substr($this->videoDuration, strpos($this->videoDuration, 'M') + 1, -1);
        if ($secondes < 10) {
            $secondes = '0'.$secondes;
        }
        return $minutes.':'.$secondes;
    }

    public function setVideoDuration($videoDuration)
    {
        $this->videoDuration = $videoDuration;
        return $this;
    }

    public function getVideoInformation($memcacheActif)
    {
        $youtubeVideo = new YoutubeVideo($this->idVideo, $memcacheActif);
        $result = $youtubeVideo->getResult();
        $this->videoDuration = $result->items[0]->contentDetails->duration;
        $this->videoName = $result->items[0]->snippet->title;
    }

} 