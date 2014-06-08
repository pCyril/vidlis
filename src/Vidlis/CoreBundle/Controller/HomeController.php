<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Vidlis\CoreBundle\Controller\AuthController;
use Vidlis\CoreBundle\Entity\PlayedQuery;
use Vidlis\CoreBundle\GoogleApi\Contrib\apiYoutubeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class HomeController extends Controller
{

    /**
     * @Route("/", name="_home")
     * @Route("/fr/")
     * @Route("/share/{idVideo}")
     * @Template()
     * @Cache(expires="tomorrow")
     */
    public function indexAction($idVideo = null)
    {
        $data = array();
        if (!is_null($idVideo)) {
            $youtubeVideoService = $this->get('youtubeVideo');
            $result = $youtubeVideoService->setId($idVideo)->getResult();
            $data['title'] = $result->items[0]->snippet->title . ' - Vidlis';
            $data['og_image'] = $result->items[0]->snippet->thumbnails->medium->url;
            $data['og_title'] = $result->items[0]->snippet->title . ' - Vidlis';
        } else {
            $data['title'] = 'Vidlis';
        }
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Home:content.html.twig', $this->contentAction());
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            if (!is_null($idVideo)) {
                $data['launch'] = $idVideo;
            }
        }
        return $data;
    }
    
    /**
     * @Template()
     * @Cache(expires="tomorrow")
     */
    public function contentAction()
    {
        $em = $this->getDoctrine()->getManager();
        $playedQuery = new PlayedQuery($em);
        $videosPlayed = $playedQuery->setLimit(12)->setLifetime(30)->setOrderBy(array('p.datePlayed' => 'DESC'))->getList('video_played');
        $data = array('videosPlayed' => $videosPlayed);
        if ($this->getUser()) {
            $data['user'] = $this->getUser();
            $data['connected'] = true;
        } else {
            $data['connected'] = false;
        }
        return $data;
    }
    
}