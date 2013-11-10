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
     * @ORM\OneToMany(targetEntity="Playlistitem", mappedBy="playlist", cascade={"remove", "persist"})
     */
    private $items;

    /**
     * @ORM\ManyToOne(targetEntity="Vidlis\UserBundle\Entity\User", inversedBy="playlists", cascade={"remove", "persist"})
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
    }

    public function getName() 
    {
        return $this->name;
    }

    public function setName($name) 
    {
        $this->name = $name;
    }

    public function getDescription() 
    {
        return $this->description;
    }

    public function setDescription($description) 
    {
        $this->description = $description;
    }

    public function getCategory() 
    {
        return $this->category;
    }

    public function setCategory($category) 
    {
        $this->category = $category;
    }

    public function isPrivate() 
    {
        return $this->private;
    }

    public function setPrivate($private) 
    {
        $this->private = $private;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

}