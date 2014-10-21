<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vidlis\LastFmBundle\Document\ArtistQuery;


class ArtistController extends Controller
{

    /**
     * @Route("/artists/", name="_artist")
     * @Route("/artists/{artist}")
     * @Template()
     */
    public function indexAction($artist = 'a')
    {
        $data = array();
        $data['title'] = 'Liste des artistes - ' . strtoupper($artist);
        $data['artistLetter'] = $artist;
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Artist:content.html.twig', $this->contentAction($artist));
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return $data;
    }

    /**
     * @Template()
     */
    public function contentAction($artistLetter)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $artistQuery = new ArtistQuery($dm);
        $artists = $artistQuery->setArtistFirstLetter($artistLetter)->addOrderBy('name')->isProcessed()->getList();
        $data['artists'] = $artists;
        if ($this->getUser()) {
            $data['user'] = $this->getUser();
            $data['connected'] = true;
        } else {
            $data['connected'] = false;
        }
        return $data;
    }

}