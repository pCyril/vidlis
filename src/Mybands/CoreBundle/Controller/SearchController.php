<?php

namespace MyBands\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use MyBands\CoreBundle\YoutubeSearch\YoutubeSearch;

class SearchController extends Controller
{
    /**
     * @Route("/search/{searchValue}", name="_homeSearch")
     * @Template()
     */
    public function indexAction($searchValue)
    {
        $data = array();
        $data['title'] = 'Recherche - Site de promotion musicale';
        $data['searchValue'] = $searchValue;
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('MyBandsCoreBundle:Search:content.html.twig', $this->contentAction($searchValue));
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
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
        $search = new YoutubeSearch($searchValue, $this->getRequest()->getLocale());
        $data['resultsSearch'] = $search->getResults();
        return $data;
    }
    
}