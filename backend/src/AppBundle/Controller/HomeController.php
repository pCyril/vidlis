<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\PlayedQuery;
use AppBundle\Youtube\YoutubeVideo;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends FOSRestController
{
    /**
     * @return array
     */
    public function getHomeAction()
    {
        $em = $this->get('doctrine')->getManager();
        /** @var YoutubeVideo $youtubeVideoService */
        $youtubeVideoService  = $this->get('youtubeVideo');

        $playedQuery = new PlayedQuery($em);
        $videosPlayed = $playedQuery->getLastPlayed(12);

        $data = [];

        foreach ($videosPlayed as $item) {
            $youtubeVideoService->setId($item[0]->getIdVideo());
            $result = $youtubeVideoService->getResult();
            if (!empty($result) && isset($result['items'][0])) {
                $data[] = json_decode(json_encode($result['items'][0]), true);
            }
        }

        return new JsonResponse($data);
    }
}
