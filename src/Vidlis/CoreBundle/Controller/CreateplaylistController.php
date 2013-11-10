<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Vidlis\CoreBundle\Entity\Playlist;
use Vidlis\CoreBundle\Entity\Playlistitem;
use Vidlis\CoreBundle\Form\PlaylistType;

class CreateplaylistController extends Controller
{
    
    /**
     * @Route("/create-playlist/{vidId}", name="_formCreatePlaylist")
     * @Template()
     */
    public function createAction($vidId)
    {
        $data['result'] = true;
        $data['title'] = 'Créer une nouvelle playlist';
        $created = false;
        $playlist = new Playlist();
        $form = $this->createForm(new PlaylistType());
        if ($this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $playlist = $form->getData();
                $playlist->setUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($playlist);
                $em->flush();
                $playlistItem = new Playlistitem();
                $playlistItem->setPlaylist($playlist)
                    ->setIdVideo($vidId)
                    ->getVideoInformation($this->container->getParameter('memcache_active'));
                $em->persist($playlistItem);
                $em->flush();
                $created = true;
            }
            $data['content'] = $this->renderView('VidlisCoreBundle:Createplaylist:create.html.twig', array('form' => $form->createView(), 'idVideo' => $vidId, 'created' => $created, 'playlist' => $playlist));
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            $data['content'] = $this->renderView('VidlisCoreBundle:Createplaylist:create.html.twig', array('form' => $form->createView(), 'idVideo' => $vidId, 'created' => $created));
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
        $data['content'] = $this->renderView('VidlisCoreBundle:Createplaylist:addto.html.twig', array('playlists' => $this->getUser()->getPlaylists()));
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
}
