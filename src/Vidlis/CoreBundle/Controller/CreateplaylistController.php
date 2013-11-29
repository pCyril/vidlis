<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Vidlis\CoreBundle\Entity\Playlist;
use Vidlis\CoreBundle\Entity\Playlistitem;
use Vidlis\CoreBundle\Entity\PlaylistItemQuery;
use Vidlis\CoreBundle\Entity\PlaylistQuery;
use Vidlis\CoreBundle\Form\PlaylistType;

class CreateplaylistController extends Controller
{
    
    /**
     * @Route("/create-playlist/{vidId}", name="_formCreatePlaylist")
     * @Template()
     */
    public function createAction($vidId=null)
    {
        $data['result'] = true;
        $data['title'] = 'Créer une nouvelle playlist';
        $created = false;

        $dataContent = array();
        if ($this->getUser()) {
            $dataContent['connected']= true;
            $dataContent['user']=  $this->getUser();
        } else {
            $dataContent['connected']= false;
        }
        $playlist = new Playlist();
        $form = $this->createForm(new PlaylistType());
        if ($this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $playlist = $form->getData();
                $playlist->setUser($this->getUser());
                $playlist->setCreationDate(new \DateTime());
                $em = $this->getDoctrine()->getManager();
                $playlistQuery = new PlaylistQuery($em);
                $playlistQuery->persist($playlist);
                if ($vidId != null) {
                    $playlistItem = new Playlistitem();
                    $playlistItem->setPlaylist($playlist)
                        ->setIdVideo($vidId)
                        ->getVideoInformation($this->container->getParameter('memcache_active'));
                    $playlistItemQuery = new PlaylistItemQuery($em);
                    $playlistItemQuery->persist($playlistItem);
                    $dataContent['savePlaylist'] = false;
                } else {
                    $dataContent['savePlaylist'] = true;
                }
                $created = true;
            }

            $dataContent = array_merge($dataContent, array('form' => $form->createView(), 'idVideo' => $vidId, 'created' => $created, 'playlist' => $playlist));

            $data['content'] = $this->renderView('VidlisCoreBundle:Createplaylist:create.html.twig', $dataContent);
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            $dataContent = array_merge($dataContent, array('form' => $form->createView(), 'idVideo' => $vidId, 'created' => $created));
            $data['content'] = $this->renderView('VidlisCoreBundle:Createplaylist:create.html.twig', $dataContent);
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

    /**
     * @Route("/update-playlist/{playlistId}", name="_formUpdatePlaylist")
     * @Template()
     */
    public function updateAction($playlistId)
    {
        $data['result'] = true;
        $data['title'] = 'Modification de votre playlist';
        $updated = false;

        $dataContent = array();
        if ($this->getUser()) {
            $dataContent['connected']= true;
            $dataContent['user']=  $this->getUser();
        } else {
            $dataContent['connected']= false;
        }
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playlist = $playlistQuery->setId($playlistId)->getSingle('playlist_'.$playlistId);
        $form = $this->createForm(new PlaylistType(), $playlist);
        if ($this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());
            if ($playlist->getUser()->getId() == $this->getUser()->getId()) {
                if ($form->isValid()) {
                    $playlist = $form->getData();
                    $playlistQuery->persist($playlist);
                    $updated = true;
                }
            } else {
                $updated = false;
            }
            $dataContent = array_merge($dataContent, array('form' => $form->createView(), 'updated' => $updated, 'playlist' => $playlist));
            $data['content'] = $this->renderView('VidlisCoreBundle:Createplaylist:update.html.twig', $dataContent);
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            $dataContent = array_merge($dataContent, array('form' => $form->createView(), 'updated' => $updated, 'playlist' => $playlist));
            $data['content'] = $this->renderView('VidlisCoreBundle:Createplaylist:update.html.twig', $dataContent);
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

    /**
     * @Route("/add-to-playlist/{idPlaylist}/{vidId}", requirements={"idPlaylist" = "\d+"}, name="_formAddToPlaylist")
     * @Template()
     */
    public function addtoAction($idPlaylist, $vidId=null)
    {
        $data['result'] = true;
        $data['title'] = 'Ajout ce titre à une playlist';
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playlistItemQuery = new PlaylistItemQuery($em);
        $playlist = $playlistQuery->setId($idPlaylist)->getSingle('playlist_'.$idPlaylist);
        $playlistItem = new Playlistitem();
        if ($playlist->getUser()->getId() == $this->getUser()->getId()) {
            $playlistItem->setPlaylist($playlist)
                ->setIdVideo($vidId)
                ->getVideoInformation($this->container->getParameter('memcache_active'));
            $playlistItemQuery->persist($playlistItem);
            $playlistQuery->prePersist($playlist);
            $result = true;
        } else {
            $result = false;
        }
        $data['content'] = $this->renderView('VidlisCoreBundle:Createplaylist:addto.html.twig', array('playlistItem' => $playlistItem, 'result' => $result));
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
}
