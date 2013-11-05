<?php

namespace Vidlis\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $form = $this->createForm(new PlaylistType());
        $data['content'] = $this->renderView('VidlisCoreBundle:Createplaylist:create.html.twig', array('form' => $form->createView()));
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
        
    /**
     * @Route("/add-to-playlist/{vidId}", name="_formAddToPlaylist")
     * @Template()
     */
    public function addtoAction($vidId)
    {
        $data['result'] = true;
        $data['title'] = 'Ajout ce titre à une playlist';
        $data['content'] = $this->renderView('VidlisCoreBundle:Createplaylist:addto.html.twig');
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
}
