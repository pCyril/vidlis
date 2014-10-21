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
     * @Route("/artists/{artist}", name="_artistLetter")
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
        if ($artistLetter != 'a-z') {
            $artists = $artistQuery->setArtistFirstLetter($artistLetter)->addOrderBy('name')->isProcessed()->getList();
        } else {
            $artists = $artistQuery->addOrderBy('name')->isProcessed()->getList();
        }
        $data['letters'] = array('a-z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r',
        's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
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