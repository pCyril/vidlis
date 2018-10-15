<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;

/**
 * @ORM\Entity()
 * @ORM\Table(name="played")
 */
class Played {

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
     * @ORM\Column(type="datetime")
     */
    private $datePlayed;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="played")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    public function __construct()
    {
        $this->datePlayed = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDatePlayed()
    {
        return $this->datePlayed;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDatePlayed($date)
    {
        $this->datePlayed = $date;

        return $this;
    }

    /**
     * @param string $idVideo
     *
     * @return $this
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

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

}
