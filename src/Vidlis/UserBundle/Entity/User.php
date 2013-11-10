<?php
namespace Vidlis\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;

use Doctrine\ORM\Mapping as ORM;
use Vidlis\CoreBundle\Entity\Playlist;

/**
 * @ORM\Entity
 * @ORM\Table(name="vidlis_users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Vidlis\CoreBundle\Entity\Playlist", mappedBy="user", cascade={"remove", "persist"})
     */
    private $playlists;

    public function __construct()
    {
        parent::__construct();
        $this->playlists = new ArrayCollection();
    }

    public function getPlaylists()
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist)
    {
        $this->playlists[] = $playlist;
    }

    public function setPlayslists(ArrayCollection $playlists)
    {
        $this->playlists = $playlists;
    }

}