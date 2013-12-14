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

/**
 * Class PlaylistActionsController
 *
 * Manage Playlist actions
 */
class PlaylistActionsController extends Controller
{
    
    /**
     * @Route("/create-playlist/{vidId}", name="_formCreatePlaylist")
     * @Template()
     */
    public function createAction($vidId=null)
    {
        $data['title'] = 'Créer une nouvelle playlist';
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $created = false;

        $dataContent = array();
        if ($this->getUser()) {
            $dataContent['connected']= true;
            $dataContent['user']=  $this->getUser();
            $playlist = new Playlist();
            $form = $this->createForm(new PlaylistType());
            if ($this->getRequest()->isMethod('POST')) {
                $form->handleRequest($this->getRequest());
                if ($form->isValid()) {
                    $playlist = $form->getData();
                    $playlist->setUser($this->getUser())
                        ->setCreationDate(new \DateTime());
                    $playlistQuery->persist($playlist);
                    if ($vidId != null) {
                        $playlistItem = new Playlistitem();
                        $playlistItem->setPlaylist($playlist)
                            ->setIdVideo($vidId)
                            ->getVideoInformation($this->get('youtubeVideo'));
                        $playlistItemQuery = new PlaylistItemQuery($em);
                        $playlistItemQuery->persist($playlistItem);
                        $dataContent['savePlaylist'] = false;
                    } else {
                        $dataContent['savePlaylist'] = true;
                    }
                    $created = true;
                }
                $dataContent['playlist'] = $playlist;
            }
            $dataContent = array_merge($dataContent, array('form' => $form->createView(), 'idVideo' => $vidId, 'created' => $created));
        } else {
            $dataContent['connected']= false;
        }
        $data['content'] = $this->renderView('VidlisCoreBundle:PlaylistActions:create.html.twig', $dataContent);
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/update-playlist/{playlistId}", name="_formUpdatePlaylist")
     * @Template()
     */
    public function updateAction($playlistId)
    {
        $data['title'] = 'Modification de votre playlist';
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $updated = false;

        $dataContent = array();
        if ($this->getUser()) {
            $dataContent['connected']= true;
            $dataContent['user']=  $this->getUser();
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
            }
            $dataContent['form'] = $form->createView();
            $dataContent['updated'] = $updated;
            $dataContent['playlist'] = $playlist;
        } else {
            $dataContent['connected']= false;
        }
        $data['content'] = $this->renderView('VidlisCoreBundle:PlaylistActions:update.html.twig', $dataContent);
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @Route("/delete-playlist/{idPlaylist}", requirements={"idPlaylist" = "\d+"}, name="_deletePlaylist")
     * @Template()
     */
    public function deleteAction($idPlaylist)
    {
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
        $data['content'] = $this->renderView('VidlisCoreBundle:PlaylistActions:delete.html.twig', array('result' => $result));
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
        $data['content'] = $this->renderView('VidlisCoreBundle:PlaylistActions:deleteitem.html.twig', array('result' => $result));
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/add-to-playlist/{idPlaylist}/{vidId}", requirements={"idPlaylist" = "\d+"}, name="_formAddToPlaylist")
     * @Template()
     */
    public function addtoAction($idPlaylist, $vidId=null)
    {
        $data['title'] = 'Ajout d\'une vidéo';
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playlistItemQuery = new PlaylistItemQuery($em);
        $playlist = $playlistQuery->setId($idPlaylist)->getSingle('playlist_'.$idPlaylist);
        if ($playlist->getUser()->getId() == $this->getUser()->getId()) {
            $playlistItem = new Playlistitem();
            $playlistItem->setPlaylist($playlist)
                ->setIdVideo($vidId)
                ->getVideoInformation($this->get('youtubeVideo'));
            $playlistItemQuery->persist($playlistItem);
            $result = true;
        } else {
            $result = false;
        }
        $data['content'] = $this->renderView('VidlisCoreBundle:PlaylistActions:addto.html.twig', array('playlistItem' => $playlistItem, 'result' => $result));
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
        $data['content'] = $this->renderView('VidlisCoreBundle:PlaylistActions:addfavorite.html.twig', array('result' => $result));
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
}
