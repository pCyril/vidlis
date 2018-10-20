<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Artist;
use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;


class ArtistController extends FOSRestController
{
    /**
     * @Get("/artists/search")
     * @param Request $request
     * @return array
     */
    public function getSearchArtistsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $artistRepository = $em->getRepository('AppBundle:Artist');

        return $artistRepository->findBy([], [], 0, 12);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getArtistsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $artistRepository */
        $artistRepository = $em->getRepository('AppBundle:Artist');

        return $artistRepository->findBy([], ['name' => 'ASC'], 12, 0);
    }

    /**
     * @Get("/artists/{artist}")
     * @param Artist $artist
     *
     * @return array
     */
    public function getArtistAction(Artist $artist)
    {
        return $artist;
    }

}
