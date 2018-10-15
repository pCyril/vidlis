<?php

namespace AppBundle\Controller;

use Doctrine\ODM\MongoDB\Cursor;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use AppBundle\Document\ArtistQuery;


class ArtistController extends FOSRestController
{
    /**
     * @Get("/artists/search")
     * @param Request $request
     * @return array
     */
    public function getSearchArtistsAction(Request $request)
    {
        $search = $request->get('query');

        $dm = $this->get('doctrine_mongodb')->getManager();
        $artistQuery = new ArtistQuery($dm);
        $artists = $artistQuery
            ->addOrderBy('name')
            ->isProcessed()
            ->isNotDisabled()
            ->setSearchLike($search)->getList();

        $artistsSerialized = [];
        foreach ($artists as $row) {
            $artistsSerialized[] = $row;
        }

        return $artistsSerialized;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getArtistsAction(Request $request)
    {
        $limit = $request->get('limit', 20);
        $offset = $request->get('offset', 0);
        $tag = $request->get('gender', null);

        $tag = ($tag != 'null' && $tag != 'all' ) ? $tag : null;

        $dm = $this->get('doctrine_mongodb')->getManager();
        $artistQuery = new ArtistQuery($dm);
        $artistQuery
            ->addOrderBy('name')
            ->isProcessed()
            ->isNotDisabled()
            ->setLimit($limit, $offset);
        if (!is_null($tag)) {
            $artistQuery->addTag($tag);
        }
        $artists = $artistQuery
            ->getList();

        $artistsSerialized = [];
        foreach ($artists as $row) {
            $artistsSerialized[] = $row;
        }

        return $artistsSerialized;
    }

    /**
     * @Get("/artists/{id}")
     * @param Request $request
     * @return array
     */
    public function getArtistAction(Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $artistQuery = new ArtistQuery($dm);
        $artist = $artistQuery
            ->isProcessed()
            ->setId($request->get('id'))
            ->getSingle();

        return $artist;
    }

}
