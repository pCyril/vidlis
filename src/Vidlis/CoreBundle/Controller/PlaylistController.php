<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
    public function indexallAction()
    {
        $data = array();
        $data['title'] = 'Playlists';

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
        return array('playlists' => $playlists);
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
    
}