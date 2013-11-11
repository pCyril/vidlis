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
                $playlist->setCreationDate(new \DateTime());
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
        $em = $this->getDoctrine()->getManager();
        $playlist = $em->getRepository('VidlisCoreBundle:Playlist')->find($idPlaylist);
        $playlistItem = new Playlistitem();
        if ($playlist->getUser()->getId() == $this->getUser()->getId()) {
            $playlistItem->setPlaylist($playlist)
                ->setIdVideo($vidId)
                ->getVideoInformation($this->container->getParameter('memcache_active'));
            $em->persist($playlistItem);
            $em->flush();
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
