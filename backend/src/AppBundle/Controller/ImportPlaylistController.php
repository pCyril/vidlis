<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\PlaylistItemQuery;
use AppBundle\Entity\PlaylistQuery;
use AppBundle\Entity\Playlist;
use AppBundle\Entity\PlaylistItem;
use AppBundle\GoogleApi\Contrib\apiYoutubeService;
use AppBundle\Controller\AuthController;

class ImportPlaylistController extends AuthController
{
    /**
     * @Route("/import-playlist", name="_importPlaylist")
     * @Template()
     */
    public function importAction()
    {
        $this->initialize();
        $request = $this->getRequest();
        $data = array();
        if ($request->getSession()->get('token')) {
            if ($request->isXmlHttpRequest()) {
                $playlistIds = $request->request->get('playlistIds');
                $em = $this->getDoctrine()->getManager();
                $playlistQuery = new PlaylistQuery($em);
                $playlistItemQuery = new PlaylistItemQuery($em);
                foreach ($playlistIds as $id) {
                    $playlist = new Playlist();
                    $playlist->setName($this->get('youtubePlaylist')->setId($id)->getSingleResult()->snippet->title)
                        ->setPrivate(false)
                        ->setUser($this->getUser())
                        ->setCreationDate(new \DateTime());
                    $playlistQuery->persist($playlist);
                    $results = $this->get('youtubePlaylistItems')->setIdPlaylist($id)->getResults();
                    foreach ($results->items as $item) {
                        $playlistItem = new Playlistitem();
                        $playlistItem->setPlaylist($playlist)
                            ->setIdVideo($item->snippet->resourceId->videoId)
                            ->getVideoInformation($this->get('youtubeVideo'));
                        $playlistItemQuery->persist($playlistItem);
                    }
                }
                $data['playlistImported'] = true;
            } else {
                $this->client->setAccessToken($request->getSession()->get('token'));
                $youtube = new apiYouTubeService($this->client);
                $playlists = $youtube->playlists->listPlaylists('snippet', array(
                    'mine' => 'true', 'maxResults' => 20
                ));
                $data['playlists'] = $playlists;
            }
        } else {
            $this->initialize();
            $state = mt_rand();
            $this->client->setState($state);
            $request->getSession()->set('stateYoutube', $state);
            $authUrl = $this->client->createAuthUrl();
            $data['authUrl'] = $authUrl;
        }

        return $data;
    }
}
