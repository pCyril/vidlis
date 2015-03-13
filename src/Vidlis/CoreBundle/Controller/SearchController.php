<?php
namespace Vidlis\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    /**
     * @Route("/search/{searchValue}", name="_homeSearch", requirements={"searchValue" = ".+"})
     * @Template()
     */
    public function indexAction($searchValue)
    {
        $data = array();
        $data['title'] = 'Recherche '.$searchValue;
        $data['searchValue'] = $searchValue;
        if ($this->getRequest()->isMethod('POST')) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Search:content.html.twig', $this->contentAction($searchValue));
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return $data;
    }
    
    /**
     * @Template()
     */
    public function contentAction($searchValue)
    {
    	$data = array();
        $data['searchValue'] = $searchValue;
        $data['resultsSearch'] = $this->get('youtubeSearch')->setQuery($searchValue)->getResults();
        $data['user'] = $this->getUser();
        return $data;
    }

    /**
     * @Route("/searchRemote/{searchValue}", name="_searchRemote", requirements={"searchValue" = ".+"})
     * @Template()
     */
    public function searchRemoteAction($searchValue)
    {
        $response = new Response(
            json_encode($this->contentAction($searchValue)),
            201,
            array(
                'Access-Control-Allow-Origin' => '*',
                'Content-Type' => 'application/json')
        );
        return $response;
    }

}
