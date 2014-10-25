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
     * @Template()
     */
    public function indexAction()
    {
        $data = array();
        $data['title'] = 'Liste des artistes - Vidlis';
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Artist:content.html.twig', $this->contentAction());
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return $data;
    }

    /**
     * @Template()
     */
    public function contentAction($limit = 20, $offset = 0)
    {
        $data = array();
        $data['artists'] = $this->getArtistList($limit, $offset);
        if ($this->getUser()) {
            $data['user'] = $this->getUser();
            $data['connected'] = true;
        } else {
            $data['connected'] = false;
        }
        return $data;
    }

    /**
     * @Route("/load/artists/{limit}/{offset}", name="_loadMore")
     * @Template()
     */
    public function itemListAction($limit, $offset)
    {
        $data = array();
            $data['artists'] = $this->getArtistList($limit, $offset);
        if ($this->getUser()) {
            $data['user'] = $this->getUser();
            $data['connected'] = true;
        } else {
            $data['connected'] = false;
        }
        $data['html'] = $this->renderView('VidlisCoreBundle:Artist:itemList.html.twig', $data);
        $data['offset'] = $offset + $limit;
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function getArtistList($limit, $offset)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $artistQuery = new ArtistQuery($dm);
        $artists = $artistQuery
            ->addOrderBy('name')
            ->isProcessed()
            ->setLimit($limit, $offset)
            ->getList();
        return $artists;
    }

    /**
     * @Route("artist/{artistName}", name="_artistInfo")
     * @Template()
     */
    public function artistAction($artistName)
    {

    }

}