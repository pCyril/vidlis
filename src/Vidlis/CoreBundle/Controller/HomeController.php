<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Vidlis\CoreBundle\Controller\AuthController;
use Vidlis\CoreBundle\GoogleApi\Contrib\apiYoutubeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class HomeController extends Controller
{

    /**
     * @Route("/", name="_home")
     * @Route("/fr/")
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
        }
        return $data;
    }
    
    /**
     * @Template()
     * @Cache(expires="tomorrow")
     */
    public function contentAction()
    {
        return array();
    }
    
}