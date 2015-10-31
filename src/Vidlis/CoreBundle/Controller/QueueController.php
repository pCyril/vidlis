<?php
namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vidlis\CoreBundle\Entity\Played;
use Vidlis\CoreBundle\Entity\PlayedQuery;
use Vidlis\LastFmBundle\Document\ArtistQuery;

class QueueController extends Controller
{
    /**
     * @Route("/addToQueue", name="_addToQueue")
     * @Template()
     */
    public function addtoqueueAction()
    {
        $data = [];
        $idVideo = $this->getRequest()->request->get('videoid');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $data['video'] = $this->get('youtubeVideo')->setId($idVideo)->getResult();
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
    }

    /**
     * @Route("/videoInformationRemote/{videoId}", name="_videoInformation", requirements={"videoId" = ".+"})
     * @Template()
     */
    public function videoInformationAction($videoId)
    {
        $data = [];
        $data['video'] = $this->get('youtubeVideo')->setId($videoId)->getResult();
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/played", name="_played")
     * @Template()
     */
    public function playedAction()
    {
        $data = [];
        $idVideo = $this->getRequest()->request->get('videoid');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $played = new Played();
            $played->setIdVideo($idVideo)
                ->setDatePlayed(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $playedQuery = new PlayedQuery($em);
            if ($this->getUser()) {
                $played->setUser($this->getUser());
            }
            $playedQuery->persist($played);
            $data['video'] = $this->get('youtubeVideo')->setId($idVideo)->getResult();
            $title = $data['video']->items[0]->snippet->title;
            $result = $this->get('lastFmMusicSearch')->setTrack($title)->getResults();
            $trackMatches = $result->results->trackmatches;
            if (isset($trackMatches->track)) {
                $artistName = $trackMatches->track[0]->artist;
                $artistQuery = new ArtistQuery($this->get('doctrine_mongodb')->getManager());
                $artist = $artistQuery->setName($artistName)->getSingle();
                if (!$artist) {
                    $this->get('ArtistCreator')->setArtistName($artistName)->run();
                }
            }

            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
    }

    /**
     * @Route("/getVideoInfo/{videoId}", name="_getInfoVideo")
     * @Template()
     */
    public function getinfovideoAction($videoId)
    {
        $data = [];
        if ($this->getRequest()->isXmlHttpRequest()) {
            $data['video'] = $this->get('youtubeVideo')->setId($videoId)->getResult();
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
    }
}
