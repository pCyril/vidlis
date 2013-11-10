<?php
namespace Vidlis\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=10)
     */
    private $idVideo;

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
    }

    /**
     * @return mixed
     */
    public function getIdVideo()
    {
        return $this->idVideo;
    }

} 