<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Playlist;
use AppBundle\Entity\Playlistitem;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PlaylistQuery;
use Symfony\Component\HttpFoundation\Response;

class PlaylistController extends FOSRestController
{

    /**
     * @param Request $request
     * @return array
     */
    public function getPlaylistsAction(Request $request)
    {
        $limit = 12;
        $offset = $request->get('offset', 0);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $playlistQuery = new PlaylistQuery($em);
        $playlists = $playlistQuery
            ->setPrivate(false)
            ->setOrderBy(['p.creationDate' => 'DESC'])
            ->setLimit($limit, $offset)
            ->getList(sprintf('key_playlist_unprivate_%d_%d', $limit, $offset));

        return $playlists;
    }

    /**
     * @param Request $request
     *
     * @return Response|Playlist
     */
    public function postPlaylistAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($this->getUser() === null) {
            return New Response('Not connected', Response::HTTP_UNAUTHORIZED);
        }

        $playlist = new Playlist();
        $playlist->setUser($this->getUser())
            ->setCreationDate(new \DateTime())
            ->setName($request->get('name'))
            ->setPrivate($request->get('private', false));

        $em->persist($playlist);

        $ids = $request->get('ids');

        foreach ($ids as $id) {
            $playlistItem = new Playlistitem();
            $playlistItem
                ->setIdVideo($id)
                ->setPlaylist($playlist)
                ->getVideoInformation($this->get('youtubeVideo'));

            $playlist->addItem($playlistItem);
            $em->persist($playlistItem);
        }

        $em->flush();

        return $playlist;
    }
}
