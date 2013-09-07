<?php

namespace MyBands\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    private $em;


    /**
     * @Route("/", name="_home")
     * @Template()
     */
    public function indexAction()
    {
        $data = array();
        $data['title'] = 'MyBands - Site de promotion musicale';
        
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('MyBandsCoreBundle:Home:content.html.twig', $this->contentAction());
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