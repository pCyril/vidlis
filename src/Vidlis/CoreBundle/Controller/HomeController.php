<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Vidlis\CoreBundle\Entity\PlayedQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Vidlis\CoreBundle\Memcache\MemcacheService;

class HomeController extends Controller
{

    /**
     * @Route("/", name="_home")
     * @Route("/share/{idVideo}")
     * @Template()
     * @Cache(expires="tomorrow")
     */
    public function indexAction($idVideo = null)
    {
        $data = [];
        if (!is_null($idVideo)) {
            $youtubeVideoService = $this->get('youtubeVideo');
            $result = $youtubeVideoService->setId($idVideo)->getResult();
            $data['title'] = $result->items[0]->snippet->title . ' - Vidlis';
            $data['og_image'] = $result->items[0]->snippet->thumbnails->medium->url;
            $data['og_title'] = $result->items[0]->snippet->title . ' - Vidlis';
        } else {
            $data['title'] = 'Vidlis';
        }
        if ($this->getRequest()->isXmlHttpRequest()) {
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
        $videosPlayed = $playedQuery->getLastPlayed(12);

        /** @var MemcacheService $memcache */
        $memcache = $this->get('memcache');

        $selectedImages = $memcache->get('selectedImages');
        if (!$selectedImages) {
            $selectedImages = [];
            $images = glob('images/albums/*.png');
            $i = 0;
            while ($i < 70) {
                $image = array_rand($images);
                $selectedImages[] = $images[$image];
                unset($images[$image]);
                $i++;
            }
            $memcache->set('selectedImages', $selectedImages, 3600);
        }

        $data = [
            'videosPlayed' => $videosPlayed,
            'tab' => 'home',
            'images' => $selectedImages,
        ];
        if ($this->getUser()) {
            $data['user'] = $this->getUser();
            $data['connected'] = true;
        } else {
            $data['connected'] = false;
        }

        return $data;
    }

    /**
     * @Route("/share/popup/{idVideo}", name="_sharePopup")
     * @Template()
     */
    public function sharePopupAction($idVideo = null)
    {
        $data = [];
        $data['title'] = "Partager c'est cool !";
        $data['content'] = $this->renderView('VidlisCoreBundle:Home:sharePopup.html.twig', ['idVideo' => $idVideo]);
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
