<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vidlis\CoreBundle\Entity\Played;
use Vidlis\CoreBundle\Entity\PlayedQuery;
use Vidlis\CoreBundle\Youtube\YoutubeVideo;

class QueueController extends Controller
{
    /**
     * @Route("/addToQueue", name="_addToQueue")
     * @Template()
     */
    public function addtoqueueAction()
    {
        $data = array();
        $idVideo = $this->getRequest()->request->get('videoid');
        if ($this->getRequest()->isMethod('POST')) {
            $played = new Played();
            $played->setIdVideo($idVideo)
                ->setDatePlayed(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $playedQuery = new PlayedQuery($em);
            $playedQuery->persist($played);
            $video = $this->get('youtubeVideo');
            $video->setId($idVideo);
            $data['video'] = $video->getResult();
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
        $data = array();
        if ($this->getRequest()->isMethod('POST')) {
            $data['video'] = $this->get('youtubeVideo')->setId($videoId)->getResult();
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }
}
