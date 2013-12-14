<?php
namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vidlis\CoreBundle\Entity\PlaylistQuery;

class PlaylistController extends Controller
{
    /**
     * @Route("/playlists", name="_homePlaylists")
     * @Template()
     */
    public function indexAction()
    {
        $data = array();
        $data['title'] = 'Playlists';
        
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Playlist:content.html.twig', $this->contentAction());
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
        if ($this->getUser()) {
            return array('user' => $this->getUser(), 'connected' => true);
        } else {
            return array('connected' => false);
        }
    }

    /**
     * @Route("/playlists/all", name="_homePlaylistsAll")
     * @Template()
     */
    public function allAction()
    {
        $data = array();
        $data['title'] = 'Toutes les playlists';
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Playlist:contentall.html.twig', $this->contentallAction());
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return $data;
    }

    /**
     * @Template()
     */
    public function contentallAction()
    {
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playlists = $playlistQuery->setPrivate(false)->getList('playlist_unprivate');
        if ($this->getUser()) {
            $data = array('user' => $this->getUser(), 'connected' => true);
        } else {
            $data = array('connected' => false);
        }
        $data['playlists'] = $playlists;
        return $data;
    }

    /**
     * @Route("/playlist/{idPlaylist}", name="_commentPlaylist")
     * @Template()
     */
    public function commentAction($idPlaylist)
    {
        $data = array();
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playlist = $playlistQuery->setId($idPlaylist)->getSingle('playlist_'.$idPlaylist);
        $data['title'] = $playlist->getName().' - Playlist';
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Playlist:contentcomment.html.twig', $this->contentcommentAction($idPlaylist));
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            $data['idPlaylist'] = $idPlaylist;
        }
        return $data;
    }

    /**
     * @Template()
     */
    public function contentcommentAction($idPlaylist)
    {
        $data = array();
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playlist = $playlistQuery->setId($idPlaylist)->getSingle('playlist_'.$idPlaylist);
        $data['playlist'] = $playlist;
        if ($this->getUser()) {
            $data['connected'] = true;
            $data['user'] = $this->getUser();
        } else {
            $data['connected'] = false;
        }
        return $data;
    }

    /**
     * @Route("/playlists/favoris", name="_homePlaylistsFavorite")
     * @Template()
     */
    public function favoriteAction()
    {
        $data = array();
        $data['title'] = 'Mes playlists favorites';

        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Playlist:contentfavorite.html.twig', $this->contentfavoriteAction());
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return $data;
    }

    /**
     * @Template()
     */
    public function contentfavoriteAction()
    {
        if ($this->getUser()) {
            $data = array('user' => $this->getUser(), 'connected' => true);
        } else {
            $data = array('connected' => false);
        }
        return $data;
    }

}