<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vidlis\LastFmBundle\Document\Artist;
use Vidlis\LastFmBundle\Document\ArtistQuery;


class ArtistController extends Controller
{

    private $genders = [
        'Tous',
        'alternative',
        'blues',
        'dance',
        'electro',
        'hip hop',
        'jazz',
        'pop',
        'rap',
        'reggae',
        'rock'
    ];

    /**
     * @Route("/artists/search/{search}", name="_artistSearch", requirements={"search" = ".*"})
     * @Template("VidlisCoreBundle:Artist:index.html.twig")
     */
    public function searchAction($search)
    {
        $data = array();
        $data['title'] = 'Artistes - Vidlis';
        $data['genre'] = 'search';
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Artist:content.html.twig', $this->contentSearchAction($search));
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return $data;
    }

    /**
     * @Route("/artists/", name="_artist")
     * @Route("/artists/{genre}", name="_artistGenre")
     * @Template()
     */
    public function indexAction($genre = null)
    {
        $data = array();
        $data['title'] = 'Artistes - Vidlis';
        $data['genre'] = $genre;
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Artist:content.html.twig', $this->contentAction(20, 0, $genre));
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return $data;
    }


    /**
     * @Template("VidlisCoreBundle:Artist:content.html.twig")
     */
    public function contentSearchAction($search)
    {
        $data = array();
        $dm = $this->get('doctrine_mongodb')->getManager();
        $artistQuery = new ArtistQuery($dm);
        $artists = $artistQuery
            ->addOrderBy('name')
            ->isProcessed()
            ->isNotDisabled()
            ->setSearchLike($search)->getList();
        $data['artists'] = $artists;
        $data['genre'] = 'search';
        $data['genres'] = $this->genders;
        if ($this->getUser()) {
            $data['user'] = $this->getUser();
            $data['connected'] = true;
        } else {
            $data['connected'] = false;
        }
        return $data;
    }

    /**
     * @Template()
     */
    public function contentAction($limit = 20, $offset = 0, $genre)
    {
        $data = array();
        $data['artists'] = $this->getArtistList($limit, $offset, $genre);
        $data['genre'] = $genre;
        $data['genres'] = $this->genders;
        if ($this->getUser()) {
            $data['user'] = $this->getUser();
            $data['connected'] = true;
        } else {
            $data['connected'] = false;
        }
        return $data;
    }

    /**
     * @Route("/load/artists/{limit}/{offset}/", name="_loadMore")
     * @Route("/load/artists/{limit}/{offset}/{genre}", name="_loadMoreTag")
     * @Template()
     */
    public function itemListAction($limit, $offset, $genre = null)
    {
        $data = array();
        $data['artists'] = $this->getArtistList($limit, $offset, $genre);
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
     * @param $genre
     * @return mixed
     */
    public function getArtistList($limit, $offset, $genre = null)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $artistQuery = new ArtistQuery($dm);
        $artistQuery
            ->addOrderBy('name')
            ->isProcessed()
            ->isNotDisabled()
            ->setLimit($limit, $offset);
        if (!is_null($genre)) {
            $artistQuery->addTag($genre);
        }
        $artists = $artistQuery
            ->getList();
        return $artists;
    }

    /**
     * @Route("artist/{artistName}", name="_artistDetail", requirements={"artistName" = ".*"})
     * @Template()
     */
    public function artistAction($artistName)
    {
        $data = array();
        $data['title'] = urldecode($artistName) . ' - Vidlis';
        $data['artistName'] = urldecode($artistName);
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Artist:contentArtist.html.twig', $this->contentArtistAction($artistName));
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return $data;
    }

    /**
     * @Template()
     */
    public function contentArtistAction($artistName)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $artistQuery = new ArtistQuery($dm);
        $artist = $artistQuery
            ->isProcessed()
            ->setName(urldecode($artistName))
            ->getSingle();
        $data = array();
        $data['artist'] = $artist;
        if ($artist instanceof Artist) {
            $similarArtists = $artistQuery->reset()->getSimilarArtists($artist);
            $data['similarArtists'] = $similarArtists;
        }
        if ($this->getUser()) {
            $data['user'] = $this->getUser();
            $data['connected'] = true;
        } else {
            $data['connected'] = false;
        }
        return $data;
    }

}