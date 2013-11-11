<?php
namespace Vidlis\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @param mixed $datePlayed
     */
    public function setDatePlayed($datePlayed)
    {
        $this->datePlayed = $datePlayed;
    }

    /**
     * @return mixed
     */
    public function getDatePlayed()
    {
        return $this->datePlayed;
    }

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
