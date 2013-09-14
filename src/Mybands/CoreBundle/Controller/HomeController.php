<?php

namespace Mybands\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mybands\CoreBundle\Controller\AuthController;
use Mybands\CoreBundle\GoogleApi\Contrib\apiYoutubeService;

class HomeController extends AuthController
{
    private $em;

    /**
     * @Route("/", name="_home")
     * @Template()
     */
    public function indexAction()
    {
        $data = array();
        $data['title'] = 'Mybands - Site de promotion musicale';
        
        
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('MybandsCoreBundle:Home:content.html.twig', $this->contentAction());
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
        if ($this->getRequest()->getSession()->get('token')) {
            $this->client->setAccessToken($this->getRequest()->getSession()->get('token'));
            $youtube = new apiYouTubeService($this->client);
            $activites = $youtube->activities->listActivities('contentDetails', array(
                'mine' => 'true', 'maxResults' => 10 
                ));
            return array('activites', $activites);
        }
        return array();
    }
    
}