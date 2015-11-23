<?php
namespace Vidlis\CoreBundle\Controller;

use CoreBundle\Repository\PlaylistRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Vidlis\CoreBundle\Entity\PlaylistQuery;

class PlaylistController extends Controller
{
    /**
     * @Route("/playlists", name="_homePlaylists")
     * @Template()
     */
    public function indexAction()
    {
        $data = [];
        $data['title'] = 'Playlists';
        
        if ($this->getRequest()->isXmlHttpRequest()) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Playlist:content.html.twig', $this->contentAction());
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return $data;
    }

    /**
     * @Route("/playListsRemote/{userName}", name="_playListsRemote", requirements={"userName": ".+"})
     * @Template()
     */
    public function playListsRemoteAction($userName)
    {
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playLists = $playlistQuery->findAllPlayListsByUserName($userName)->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);

        return new Response(
            json_encode($playLists),
            201,
            [
                'Access-Control-Allow-Origin' => '*',
                'Content-Type' => 'application/json',
            ]
        );

    }

    /**
     * @Route("/playListRemote/{id}/{userName}", name="_playListRemote", requirements={"id" = "\d+","userName" = ".+"})
     * @Template()
     */
    public function playListRemoteAction($id, $userName)
    {
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playList = $playlistQuery->findPlayListByIdAndUserName($id, $userName)->getQuery()->getSingleResult(AbstractQuery::HYDRATE_ARRAY);

        return new Response(
            json_encode($playList),
            201,
            [
                'Access-Control-Allow-Origin' => '*',
                'Content-Type' => 'application/json',
            ]
        );
    }
    
    /**
     * @Template()
     */
    public function contentAction()
    {
        if ($this->getUser()) {
            $data = ['user' => $this->getUser(), 'connected' => true];
        } else {
            $data = ['connected' => false];
        }

        return $data;
    }

    /**
     * @Route("/playlists/all", name="_homePlaylistsAll")
     * @Template()
     */
    public function allAction()
    {
        $data = [];
        $data['title'] = 'Playlists';
        if ($this->getRequest()->isXmlHttpRequest()) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Playlist:contentAll.html.twig', $this->contentAllAction());
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return $data;
    }

    /**
     * @Template()
     */
    public function contentAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playlists = $playlistQuery
            ->setPrivate(false)
            ->setOrderBy(['p.creationDate' => 'DESC'])
            ->getList('playlist_unprivate');
        if ($this->getUser()) {
            $data = ['user' => $this->getUser(), 'connected' => true];
        } else {
            $data = ['connected' => false];
        }
        $data['playlists'] = $playlists;
        $data['tab'] = 'playlist';

        return $data;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @Route("/load/playlist/{limit}/{offset}", name="_loadMorePlaylist")
     * @return array
     */
    public function listItemAllAction($limit, $offset)
    {
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playlists = $playlistQuery
            ->setPrivate(false)
            ->setOrderBy(['p.creationDate' => 'DESC'])
            ->setLimit($limit, $offset)
            ->getList('playlist_unprivate_'.$limit.'_'.$offset);
        $data['playlists'] = $playlists;
        $data['html'] = $this->renderView('VidlisCoreBundle:Playlist:listItemAll.html.twig', $data);
        $data['offset'] = $offset + $limit;
        $response = new JsonResponse($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/playlist/{idPlaylist}", name="_commentPlaylist")
     * @Template()
     */
    public function commentAction($idPlaylist)
    {
        $data = [];
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playlist = $playlistQuery->setId($idPlaylist)->setPrivate(false)->getSingle('playlist_'.$idPlaylist);
        $playlistOwner = $playlistQuery
            ->initQueryBuilder()
            ->setId($idPlaylist)
            ->setUser($this->getUser())
            ->getSingle();
        if (null !== $playlist || null !== $playlistOwner) {
            $playlist = ($playlist) ? $playlist : $playlistOwner;
            $data['title'] = $playlist->getName().' - Playlist';
            if ($this->getRequest()->isXmlHttpRequest()) {
                $data['content'] = $this->renderView('VidlisCoreBundle:Playlist:contentComment.html.twig', $this->contentCommentAction($idPlaylist));
                $response = new Response(json_encode($data));
                $response->headers->set('Content-Type', 'application/json');

                return $response;
            } else {
                $data['idPlaylist'] = $idPlaylist;
            }
        } else {

            return $this->redirect($this->generateUrl('_homePlaylistsAll'));
        }

        return $data;
    }

    /**
     * @Template()
     */
    public function contentCommentAction($idPlaylist)
    {
        $data = [];
        $em = $this->getDoctrine()->getManager();
        $playlistQuery = new PlaylistQuery($em);
        $playlist = $playlistQuery->setId($idPlaylist)->getSingle('playlist_'.$idPlaylist);
        $data['playlist'] = $playlist;
        $data['tab'] = 'playlist';
        if ($this->getUser()) {
            $data['connected'] = true;
            $data['user'] = $this->getUser();
        } else {
            $data['connected'] = false;
        }

        return $data;
    }

    /**
     * @Route("/playlists/favoris", name="_homePlaylistsFavorite")
     * @Template()
     */
    public function favoriteAction()
    {
        $data = [];
        $data['title'] = 'My favorites playlist';

        if ($this->getRequest()->isXmlHttpRequest()) {
            $data['content'] = $this->renderView('VidlisCoreBundle:Playlist:contentFavorite.html.twig', $this->contentFavoriteAction());
            $response = new Response(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return $data;
    }

    /**
     * @Template()
     */
    public function contentFavoriteAction()
    {
        if ($this->getUser()) {
            $data = ['user' => $this->getUser(), 'connected' => true];
        } else {
            $data = ['connected' => false];
        }

        return $data;
    }
}
