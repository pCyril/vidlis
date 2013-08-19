<?php

namespace MyBands\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ConcertController extends Controller
{
    /**
     * @Route("/concerts", name="_homeConcerts")
     * @Template()
     */
    public function indexAction()
    {
        $data = array();
        $data['title'] = 'Concerts - Site de promotion musicale';
        
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('MyBandsCoreBundle:Concert:content.html.twig', $this->contentAction());
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