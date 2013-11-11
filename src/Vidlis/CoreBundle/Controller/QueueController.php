<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Vidlis\CoreBundle\Entity\Played;
use Vidlis\CoreBundle\Youtube\YoutubeVideo;

class QueueController extends Controller
{
    /**
     * @Route("/addToQueue", name="_addToQueue")
     * @Template()
     */
    public function addtoqueueAction()
    {
        $data = array();
        if ($this->getRequest()->isMethod('POST')) {
            $played = new Played();
            $played->setIdVideo($this->getRequest()->request->get('videoid'));
            $played->setDatePlayed(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($played);
            $em->flush();
            $video = new YoutubeVideo($this->getRequest()->request->get('videoid'), $this->container->getParameter('memcache_active'));
            $data['video'] = $video->getResult();
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }
}
