<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Vidlis\CoreBundle\Youtube\YoutubeSearch;

use Vidlis\CoreBundle\Controller\AuthController;

class SearchController extends AuthController
{
    /**
     * @Route("/search/{searchValue}", name="_homeSearch")
     * @Template()
     */
    public function indexAction($searchValue)
    {
        $data = array();
        $data['title'] = 'Recherche';
        $data['searchValue'] = $searchValue;
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Search:content.html.twig', $this->contentAction($searchValue));
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
    public function contentAction($searchValue)
    {
    	$data = array();
        $data['searchValue'] = $searchValue;
        $search = new YoutubeSearch($searchValue, $this->container->getParameter('memcache_active'));
        $data['resultsSearch'] = $search->getResults();
        $data['user'] = $this->getUser();
        return $data;
    }
    
}