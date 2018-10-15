<?php

namespace AppBundle\Controller;

use AppBundle\Document\ArtistQuery;
use AppBundle\Entity\Played;
use AppBundle\Entity\PlayedQuery;
use AppBundle\Youtube\YoutubeSuggestion;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Youtube\YoutubeVideo;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;

class VideoController extends FOSRestController
{
    /**
     * @param Request $request
     *
     * @Get("/video/{id}")
     *
     * @return array
     */
    public function getVideoDetailAction(Request $request)
    {
        /** @var YoutubeVideo $youtubeVideoService */
        $youtubeVideoService  = $this->get('youtubeVideo');
        $youtubeVideoService->setId($request->get('id'));

        return $youtubeVideoService->getResult()['items'][0];
    }

    /**
     * @param Request $request
     *
     * @Get("/video/suggests/{id}")
     *
     * @return array
     */
    public function getSuggestsAction(Request $request)
    {
        $idVideo = $request->get('id');

        return $this->get('youtubeSuggestion')->setRelatedToVideoId($idVideo)->getResults();
    }

    /**
     * @param Request $request
     *
     * @Get("/video/next/auto/{id}")
     *
     * @return array
     */
    public function getNextAutoAction(Request $request)
    {
        $ids = $request->get('ids');
        $videoId = $request->get('id');

        /** @var YoutubeSuggestion $youtubeSuggestionService */
        $youtubeSuggestionService = $this->get('youtubeSuggestion');
        $result = $youtubeSuggestionService->setRelatedToVideoId($videoId)->getResults();

        if (isset($result['items'][0])) {
            foreach ($result['items'] as $item) {
                if (!in_array($item['id']['videoId'], $ids)) {
                    $data['id'] = $item['id']['videoId'];

                    return $item;
                }
            }
        }

        return [];
    }


    /**
     * @param $id
     *
     * @Post("/played/{id}")
     *
     * @return Played
     */
    public function postPlayedAction($id)
    {
        $played = new Played();
        $played->setIdVideo($id)
            ->setDatePlayed(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $playedQuery = new PlayedQuery($em);

        if ($this->getUser()) {
            $played->setUser($this->getUser());
        }

        $playedQuery->persist($played);

        return $played;
    }
}
