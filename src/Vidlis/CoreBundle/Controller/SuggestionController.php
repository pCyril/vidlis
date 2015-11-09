<?php
namespace Vidlis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class SuggestionController extends Controller
{
    /**
     * @Route("/getSuggestion", name="_getSuggestion")
     */
    public function suggestionAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            return new Response('You don\'t have the right ;)', 500);
        }
        $data = [];
        $idVideo = $this->getRequest()->get('videoid');
        $data['suggestion'] = $this->get('youtubeSuggestion')->setRelatedToVideoId($idVideo)->getResults();

        return new JsonResponse($data);

    }

    /**
     * @Route("/getFirstSuggestionVideoId", name="_getFirstSuggestionVideoId")
     */
    public function getFirstSuggestionVideoIdAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            return new Response('You don\'t have the right ;)', 500);
        }
        $data = [];
        $data['fail'] = true;
        $idVideo = $this->getRequest()->get('videoid');
        $playlist = $this->getRequest()->get('playlist');
        if (null === $idVideo) {
            return new JsonResponse($data);
        }
        $result = $this->get('youtubeSuggestion')->setRelatedToVideoId($idVideo)->getResults();
        if (isset($result->items[0])) {
            foreach ($result->items as $item) {
                if (!in_array($item->id->videoId, $playlist)) {
                    $data['videoId'] = $item->id->videoId;
                    $data['fail'] = false;
                    return new JsonResponse($data);
                }
            }
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/getSuggestionRemote/{videoId}", name="_suggestRemote", requirements={"searchValue" = ".+"})
     */
    public function searchRemoteAction($videoId)
    {
        return new JsonResponse(
            $this->get('youtubeSuggestion')->setRelatedToVideoId($videoId)->getResults(),
            201,
            [
                'Access-Control-Allow-Origin' => '*',
                'Content-Type' => 'application/json',
            ]
        );
    }
}
