<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vidlis\CoreBundle\GoogleApi\Contrib\apiYoutubeService;
use Vidlis\CoreBundle\Controller\AuthController;

class PlaylistController extends AuthController
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
        } else {
            if (!$this->getRequest()->getSession()->get('token')) {
                $this->initialize();
                $state = mt_rand();
                $this->client->setState($state);
                $this->getRequest()->getSession()->set('stateYoutube', $state);
                $authUrl = $this->client->createAuthUrl();
                $data['authUrl'] = $authUrl;
            } else {
                $data['authUrl'] = '';
            }
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
        } else {
            if (!$this->getRequest()->getSession()->get('token')) {
                $this->initialize();
                $state = mt_rand();
                $this->client->setState($state);
                $this->getRequest()->getSession()->set('stateYoutube', $state);
                $authUrl = $this->client->createAuthUrl();
                $data['authUrl'] = $authUrl;
            } else {
                $data['authUrl'] = '';
            }
        }
        return $data;
    }

    /**
     * @Template()
     */
    public function contentallAction()
    {
        $em = $this->getDoctrine()->getManager();
        $playlists = $em->getRepository('VidlisCoreBundle:Playlist')->findByPrivate(false);
        if ($this->getUser()) {
            $data = array('user' => $this->getUser(), 'connected' => true);
        } else {
            $data = array('connected' => false);
        }
        $data['playlists'] = $playlists;
        return $data;
    }

    /**
     * @Route("/playlists/favoris", name="_homePlaylistsFavorite")
     * @Template()
     */
    public function favorisAction()
    {
        $data = array();
        $data['title'] = 'Mes playlists favorites';

        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Playlist:contentfavorite.html.twig', $this->contentfavoriteAction());
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            if (!$this->getRequest()->getSession()->get('token')) {
                $this->initialize();
                $state = mt_rand();
                $this->client->setState($state);
                $this->getRequest()->getSession()->set('stateYoutube', $state);
                $authUrl = $this->client->createAuthUrl();
                $data['authUrl'] = $authUrl;
            } else {
                $data['authUrl'] = '';
            }
        }
        return $data;
    }

    /**
     * @Template()
     */
    public function contentfavoriteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $playlists = $em->getRepository('VidlisCoreBundle:Playlist')->findByPrivate(false);
        if ($this->getUser()) {
            $data = array('user' => $this->getUser(), 'connected' => true);
        } else {
            $data = array('connected' => false);
        }
        $data['playlists'] = $playlists;
        return $data;
    }

    /**
     * @Route("/delete-playlist/{idPlaylist}", requirements={"idPlaylist" = "\d+"}, name="_deletePlaylist")
     * @Template()
     */
    public function deleteAction($idPlaylist)
    {
        $data['result'] = true;
        $data['title'] = 'Suppression de votre playlist';
        $em = $this->getDoctrine()->getManager();
        $playlist = $em->getRepository('VidlisCoreBundle:Playlist')->find($idPlaylist);
        if ($playlist->getUser()->getId() == $this->getUser()->getId()) {
            $em->remove($playlist);
            $em->flush();
            $result = true;
        } else {
            $result = false;
        }
        $data['content'] = $this->renderView('VidlisCoreBundle:Playlist:delete.html.twig', array('result' => $result));
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


        /**
         * @Route("/delete-item/{idPlaylist}/{idItem}", requirements={"idPlaylist" = "\d+", "idItem" = "\d+"}, name="_deleteItemPlaylist")
         * @Template()
         */
    public function deleteitemAction($idPlaylist, $idItem)
    {
        $data['result'] = true;
        $data['title'] = 'Suppression de l\'élément';
        $em = $this->getDoctrine()->getManager();
        $playlist = $em->getRepository('VidlisCoreBundle:Playlist')->find($idPlaylist);
        $playlistIem = $em->getRepository('VidlisCoreBundle:PlaylistItem')->find($idItem);
        if ($playlist->getUser()->getId() == $this->getUser()->getId()) {
            $em->remove($playlistIem);
            $em->flush();
            $result = true;
        } else {
            $result = false;
        }
        $data['content'] = $this->renderView('VidlisCoreBundle:Playlist:deleteitem.html.twig', array('result' => $result));
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/add-to-favorite/{idPlaylist}", requirements={"idPlaylist" = "\d+"}, name="_addFavoritePlaylist")
     * @Template()
     */
    public function addtofavoriteAction($idPlaylist)
    {
        $data['result'] = true;
        $data['title'] = 'Ajout aux favoris';
        $em = $this->getDoctrine()->getManager();
        $playlist = $em->getRepository('VidlisCoreBundle:Playlist')->find($idPlaylist);
        if ($playlist->getUser()->getId() != $this->getUser()->getId()) {
            $this->getUser()->addFavoritePlaylist($playlist);
            $em->flush();
            $result = true;
        } else {
            $result = false;
        }
        $data['content'] = $this->renderView('VidlisCoreBundle:Playlist:addfavorite.html.twig', array('result' => $result));
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/add-to-favorite", name="_importPlaylist")
     * @Template()
     */
    public function importAction()
    {
        $this->initialize();
        $data = array();
        if ($this->getRequest()->getSession()->get('token')) {
            $this->client->setAccessToken($this->getRequest()->getSession()->get('token'));
            $youtube = new apiYouTubeService($this->client);
            $playlists = $youtube->playlists->listPlaylists('snippet', array(
                'mine' => 'true', 'maxResults' => 20
            ));
            $data['playlists'] = $playlists;
        } else {
            $this->initialize();
            $state = mt_rand();
            $this->client->setState($state);
            $this->getRequest()->getSession()->set('stateYoutube', $state);
            $authUrl = $this->client->createAuthUrl();
            $data['authUrl'] = $authUrl;
        }
        return $data;
    }
    
}