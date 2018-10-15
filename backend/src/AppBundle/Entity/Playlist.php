<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlaylistRepository")
 * @ORM\Table(name="playlist")
 */
class Playlist
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\NotBlank(message="Le nom de la playlist ne peut pas être vide.")
     */
    private $name;

    /**
     * @ORM\Column(name="private", type="boolean")
     */
    private $private;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberLike = 0;

    /**
     * @var PlaylistItem[]
     *
     * @ORM\OneToMany(targetEntity="Playlistitem", mappedBy="playlist", cascade={"remove", "persist"})
     */
    private $items;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="playlists")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    public function  __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
        return $this;
    }

    public function getName() 
    {
        return $this->name;
    }

    public function setName($name) 
    {
        $this->name = $name;
        return $this;
    }

    public function isPrivate() 
    {
        return $this->private;
    }

    public function setPrivate($private) 
    {
        $this->private = $private;
        return $this;
    }

    /**
     * @param $items
     *
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param $item
     *
     * @return $this
     */
    public function addItem($item)
    {
        $this->items->add($item);

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param $creationDate
     *
     * @return $this
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param $numberLike
     *
     * @return $this
     */
    public function setNumberLike($numberLike)
    {
        $this->numberLike = $numberLike;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumberLike()
    {
        return $this->numberLike;
    }
}
