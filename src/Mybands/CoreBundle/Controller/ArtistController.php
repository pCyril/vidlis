<?php

namespace MyBands\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ArtistController extends Controller
{
    /**
     * @Route("/artistes", name="_homeArtists")
     * @Template()
     */
    public function indexAction()
    {
        $data = array();
        $data['title'] = 'Artistes - Site de promotion musicale';
        
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('MyBandsCoreBundle:Artist:content.html.twig', $this->contentAction());
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return $data;
    }
    
    /**
     * @Template()
     */
    public function contentAction()
    {
        return array();
    }
    
}