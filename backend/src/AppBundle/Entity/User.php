<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Played;
use AppBundle\Entity\Playlist;

/**
 * @ORM\Entity
 * @ORM\Table(name="vidlis_users")
 * @ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Playlist", mappedBy="user", cascade={"remove", "persist"})
     */
    private $playlists;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Playlist", cascade={"persist"})
     */
    private $favoritePlaylists;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Played", mappedBy="user", cascade={"remove", "persist"})
     */
    private $played;

    public function __construct()
    {
        parent::__construct();
        $this->playlists = new ArrayCollection();
        $this->favoritePlaylists = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return Playlist[]
     */
    public function getPlaylists()
    {
        return $this->playlists;
    }

    /**
     * @param Playlist $playlist
     * @return $this
     */
    public function addPlaylist(Playlist $playlist)
    {
        $this->playlists[] = $playlist;
        return $this;
    }

    /**
     * @param ArrayCollection $playlists
     * @return $this
     */
    public function setPlayslists(ArrayCollection $playlists)
    {
        $this->playlists = $playlists;
        return $this;
    }

    /**
     * @param Playlist $playlist
     * @return $this
     */
    public function addFavoritePlaylist(Playlist $playlist)
    {
        $this->favoritePlaylists[] = $playlist;
        return $this;
    }

    /**
     * @param Playlist $playlist
     * @return $this
     */
    public function removeFavoritePlaylist(Playlist $playlist)
    {
        $this->favoritePlaylists->removeElement($playlist);
        return $this;
    }

    /**
     * @return Playlist[]
     */
    public function getFavoritePlaylists()
    {
        return $this->favoritePlaylists;
    }

    /**
     * @return Played[]
     */
    public function getPlayed()
    {
        return $this->played;
    }
}
