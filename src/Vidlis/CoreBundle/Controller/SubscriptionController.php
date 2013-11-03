<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Vidlis\CoreBundle\Controller\AuthController;
use Vidlis\CoreBundle\GoogleApi\Contrib\apiYoutubeService;

class SubscriptionController extends AuthController
{
    private $em;

    /**
     * @Route("/subscriptions", name="_homeSub")
     * @Template()
     */
    public function indexAction()
    {
        $data = array();
        $data['title'] = 'Vidlis - Site de promotion musicale';
        
        
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Subscription:content.html.twig', $this->contentAction());
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
            $subscriptions = $youtube->subscriptions->listSubscriptions('snippet,contentDetails', array(
                'mine' => 'true', 'maxResults' => 10 
                ));
            return array('subscriptions', $subscriptions);
        }
        return array();
    }
    
}