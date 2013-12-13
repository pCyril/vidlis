<?php
namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class SuggestionController extends Controller
{
    /**
     * @Route("/getSuggestion", name="_getSuggestion")
     * @Template()
     */
    public function suggestionAction()
    {
        $data = array();
        if ($this->getRequest()->isMethod('POST')) {
            $video = $this->get('youtubeSuggestion')->setRelatedToVideoId($this->getRequest()->request->get('videoid'));
            $data['suggestion'] = $video->getResults();
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }
}
