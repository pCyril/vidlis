<?php

namespace AppBundle\Controller;

use AppBundle\Document\ArtistQuery;
use AppBundle\Entity\Played;
use AppBundle\Entity\PlayedQuery;
use AppBundle\LastFm\Artist\Creator;
use AppBundle\LastFm\Track\Search;
use AppBundle\Youtube\YoutubeSuggestion;
use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Youtube\YoutubeVideo;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;

class VideoController extends FOSRestController
{
    /**
     * @Get("/video/{id}")
     *
     * @return array
     */
    public function getVideoDetailAction($id)
    {
        /** @var YoutubeVideo $youtubeVideoService */
        $youtubeVideoService  = $this->get('youtubeVideo');
        $youtubeVideoService->setId($id);

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
        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $artistRepository */
        $artistRepository = $em->getRepository('AppBundle:Artist');

        $played = new Played();
        $played->setIdVideo($id)
            ->setDatePlayed(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $playedQuery = new PlayedQuery($em);

        if ($this->getUser()) {
            $played->setUser($this->getUser());
        }


        $video = $this->get('youtubeVideo')->setId($id)->getResult();
        $title = $video['items'][0]['snippet']['title'];

        /** @var Search $lastFmMusicSearch */
        $lastFmMusicSearch = $this->get('lastFmMusicSearch');
        $result = $lastFmMusicSearch->setTrack($title)->getResults();
        $trackMatches = $result['results']['trackmatches'];


        if (isset($trackMatches['track'])) {
            $artistName = $trackMatches['track'][0]['artist'];
            $artist = $artistRepository->findBy(['name' => $artistName]);

            if (!$artist) {
                /** @var Creator $artistCreator */
                $artistCreator = $this->get('ArtistCreator');
                $artistCreator->setArtistName($artistName)->run();
            }
        }

        $playedQuery->persist($played);

        return $played;
    }
}
