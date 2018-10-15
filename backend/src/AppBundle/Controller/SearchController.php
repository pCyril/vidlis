<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;

class SearchController extends FOSRestController
{
    /**
     * @Get("/search")
     *
     * @param Request $request
     *
     * @return array
     */
    public function getSearchResultAction(Request $request)
    {
        return json_decode(json_encode($this->get('youtubeSearch')->setQuery($request->get('query'))->getResults()), true);
    }

}
