<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vidlis\CoreBundle\Entity\Playlist;
use Vidlis\CoreBundle\Entity\PlaylistItem;
use Vidlis\CoreBundle\Entity\PlaylistItemQuery;
use Vidlis\CoreBundle\Entity\PlaylistQuery;
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

    /**
     * @Route("/delete-playlist/{idPlaylist}", requirements={"idPlaylist" = "\d+"}, name="_deletePlaylist")
     * @Template()
     */
    public function deleteAction($idPlaylist)
    {
        $data['result'] = true;
        $data['title'] = 'Suppression de votre playlist';
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playlist = $playlistQuery->setId($idPlaylist)->getSingle('playlist_'.$idPlaylist);
        if ($playlist->getUser()->getId() == $this->getUser()->getId()) {
            $playlistQuery->remove($playlist);
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
     * @Route("/delete-item/{idItem}", requirements={"idItem" = "\d+"}, name="_deleteItemPlaylist")
     * @Template()
     */
    public function deleteitemAction($idItem)
    {
        $data['result'] = true;
        $data['title'] = 'Suppression de l\'élément';
        $em = $this->getDoctrine()->getManager();
        $playlistItemQuery = new PlaylistItemQuery($em);
        $playlistIem = $playlistItemQuery->setId($idItem)->getSingle('playlistItem_'.$idItem);
        if ($playlistIem->getPlaylist()->getUser()->getId() == $this->getUser()->getId()) {
            $playlistItemQuery->remove($playlistIem);
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
        $playlistQuery = new PlaylistQuery($em);
        $playlist = $playlistQuery->setId($idPlaylist)->getSingle('playlist_'.$idPlaylist);
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
     * @Route("/import-playlist", name="_importPlaylist")
     * @Template()
     */
    public function importAction()
    {
        $this->initialize();
        $data = array();
        if ($this->getRequest()->getSession()->get('token')) {
            if ($this->getRequest()->isMethod('POST')) {
                $playlistIds = $this->getRequest()->request->get('playlistIds');
                $em = $this->getDoctrine()->getManager();
                $playlistQuery = new PlaylistQuery($em);
                $playlistItemQuery = new PlaylistItemQuery($em);
                foreach ($playlistIds as $id) {
                    $playlist = new Playlist();
                    $playlist->setName($this->get('youtubePlaylist')->setId($id)->getSingleResult()->snippet->title)
                        ->setPrivate(false)
                        ->setUser($this->getUser())
                        ->setCreationDate(new \DateTime());
                    $playlistQuery->persist($playlist);
                    $results = $this->get('youtubePlaylistItems')->setIdPlaylist($id)->getResults();
                    foreach ($results->items as $item){
                        $playlistItem = new Playlistitem();
                        $playlistItem->setPlaylist($playlist)
                            ->setIdVideo($item->snippet->resourceId->videoId)
                            ->getVideoInformation($this->get('youtubeVideo'));
                        $playlistItemQuery->persist($playlistItem);
                    }
                }
                $data['playlistImported'] = true;
            } else {
                $this->client->setAccessToken($this->getRequest()->getSession()->get('token'));
                $youtube = new apiYouTubeService($this->client);
                $playlists = $youtube->playlists->listPlaylists('snippet', array(
                    'mine' => 'true', 'maxResults' => 20
                ));
                $data['playlists'] = $playlists;
            }
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