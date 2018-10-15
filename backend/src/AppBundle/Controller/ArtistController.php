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
        return [];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getArtistsAction(Request $request)
    {

        return [];
    }

    /**
     * @Get("/artists/{id}")
     * @param Request $request
     * @return array
     */
    public function getArtistAction(Request $request)
    {

        return [];
    }

}
