<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TopController extends Controller
{
    /**
     * @Route("/top", name="_tops")
     * @Template()
     */
    public function indexAction()
    {
        $data = array();
        $data['title'] = 'Le top des écoutes - Site de promotion musicale';
        
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Top:content.html.twig', $this->contentAction());
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