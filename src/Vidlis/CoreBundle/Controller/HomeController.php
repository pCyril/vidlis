<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Vidlis\CoreBundle\Controller\AuthController;
use Vidlis\CoreBundle\GoogleApi\Contrib\apiYoutubeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class HomeController extends AuthController
{

    /**
     * @Route("/", name="_home")
     * @Template()
     * @Cache(expires="tomorrow")
     */
    public function indexAction()
    {
        $data = array();
        $data['title'] = 'Vidlis';
        
        
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Home:content.html.twig', $this->contentAction());
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            if (!$this->getRequest()->getSession()->get('token')) {
                $this->initialize();
                $state = mt_rand();
                $this->client->setState($state);
                $this->getRequest()->getSession()->set('stateYoutube', $state);
                $authUrl = $this->client->createAuthUrl();
                $data['authUrl'] = $authUrl;
            } else {
                $data['authUrl'] = '';
            }
        }
        return $data;
    }
    
    /**
     * @Template()
     */
    public function contentAction()
    {
        $this->initialize();
        $data = array();
        if ($this->getRequest()->getSession()->get('token')) {
            $this->client->setAccessToken($this->getRequest()->getSession()->get('token'));
            $youtube = new apiYouTubeService($this->client);
            $activites = $youtube->activities->listActivities('contentDetails', array(
                'mine' => 'true', 'maxResults' => 10 
                ));
            $data['activites'] = $activites;
        }
        //$data['user'] = $this->getUser();
        return $data;
    }
    
}