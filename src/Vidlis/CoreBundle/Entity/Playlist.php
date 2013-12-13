<?php
namespace Vidlis\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
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
     * @ORM\OneToMany(targetEntity="Playlistitem", mappedBy="playlist", cascade={"remove", "persist"})
     */
    private $items;

    /**
     * @ORM\ManyToOne(targetEntity="Vidlis\UserBundle\Entity\User", inversedBy="playlists")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

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

    public function getDescription() 
    {
        return $this->description;
    }

    public function setDescription($description) 
    {
        $this->description = $description;
        return $this;
    }

    public function getCategory() 
    {
        return $this->category;
    }

    public function setCategory($category) 
    {
        $this->category = $category;
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
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
        return $this;
    }

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
     * @param mixed $creationDate
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
     * @param mixed $numberLike
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