<?php

namespace AppBundle\LastFm\Artist;

use AppBundle\Entity\Artist as ArtistEntity;
use AppBundle\Entity\Album as AlbumEntity;
use AppBundle\Entity\Track as TrackEntity;
use AppBundle\LastFm\Album\Info as AlbumInfo;
use AppBundle\LastFm\Artist\Info as ArtistInfo;
use AppBundle\LastFm\Artist\Album as ArtistAlbum;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;

class Creator {

    /**
     * @ArtistInfo
     */
    private $serviceArtistInfo;

    /**
     * @ArtistAlbum
     */
    private $serviceArtistAlbum;

    /**
     * @AlbumInfo
     */
    private $serviceAlbumInfo;

    /**
     * @var String
     */
    private $artistName;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param Info $serviceArtistInfo
     * @param Album $serviceArtistAlbum
     * @param AlbumInfo $serviceAlbumInfo
     * @param $logger
     * @param $entityManager
     */
    public function __construct(ArtistInfo $serviceArtistInfo, ArtistAlbum $serviceArtistAlbum,  AlbumInfo $serviceAlbumInfo, $logger, $entityManager)
    {
        $this->serviceAlbumInfo = $serviceAlbumInfo;
        $this->serviceArtistAlbum = $serviceArtistAlbum;
        $this->serviceArtistInfo = $serviceArtistInfo;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setArtistName($name)
    {
        $this->artistName = $name;
        return $this;
    }

    /**
     * Retrieve information about artist (TopAlbum and track of album)
     */
    public function run()
    {
        if (empty($this->artistName)) {
            return;
        }

        $result = $this->serviceArtistInfo->setArtist($this->artistName)->getResults();
        if (!isset($result['error'])) {
            $artist = new ArtistEntity();
            $artist->setName($this->artistName)
                ->setInformation($result['artist']['bio']['summary']);
            if (!is_array($result['artist']['tags']['tag'])) {
                $tags = [$result['artist']['tags']['tag']];
            } else {
                $tags = $result['artist']['tags']['tag'];
            }

            $artist->setTags(implode(', ', array_map(function($tag) {
                return $tag['name'];
            }, $tags)));

            $albumResult = $this->serviceArtistAlbum
                ->setArtist($this->artistName)
                ->getResults();
            if (!isset($albumResult['error'])) {
                if (!is_array($albumResult['topalbums']['album'])) {
                    $albums = [$albumResult['topalbums']['album']];
                } else {
                    $albums = $albumResult['topalbums']['album'];
                }
                foreach ($albums as $albumResult) {
                    $album = new AlbumEntity();
                    $album->setName($albumResult['name'])
                        ->setMbid($albumResult['mbid']);

                    if ($albumResult['mbid']) {

                        if (is_array($albumResult['image'])) {
                            $image = $albumResult['image'][count($albumResult['image']) - 1];
                            $var = '#text';
                            if ('' !== $image[$var]) {
                                $album->setImage($image[$var]);
                            }
                        }

                        $albumInfoResult = $this->serviceAlbumInfo
                            ->setArtist($this->artistName)
                            ->setMbid($albumResult['mbid'])
                            ->getResults();
                        if (!isset($albumInfoResult['error'])) {
                            if (!is_array($albumInfoResult['album']['tracks']['track'])) {
                                $tracks = [$albumInfoResult['album']['tracks']['track']];
                            } else {
                                $tracks = $albumInfoResult['album']['tracks']['track'];
                            }
                            foreach ($tracks as $trackResult) {
                                $track = new TrackEntity();
                                $track->setName($trackResult['name'])
                                    ->setDuration($trackResult['duration'])
                                    ->setAlbum($album);

                                $album->addTrack($track);

                                $this->entityManager->persist($track);
                            }
                        } else {
                            $this->logger->error($albumInfoResult['error']);
                            return;
                        }

                        $album->setArtist($artist);
                        $this->entityManager->persist($album);

                        $artist->addAlbum($album);
                    }
                }
            } else {
                $this->logger->error($albumResult['error']);
                return;
            }

            $this->entityManager->persist($artist);
            $this->entityManager->flush();

        } else {
            $this->logger->error($result['error']);
            return;
        }
    }

}