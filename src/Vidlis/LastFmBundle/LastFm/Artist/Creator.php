<?php

namespace Vidlis\LastFmBundle\LastFm\Artist;

use Vidlis\LastFmBundle\Document\Artist;
use Vidlis\LastFmBundle\Document\Album as ArtistAlbumDocument;
use Vidlis\LastFmBundle\Document\Tag as ArtistTagDocument;
use Vidlis\LastFmBundle\Document\Track as ArtistTrackDocument;
use Vidlis\LastFmBundle\Document\ArtistQuery;
use Vidlis\LastFmBundle\LastFm\Album\Info as AlbumInfo;
use Vidlis\LastFmBundle\LastFm\Artist\Info as ArtistInfo;
use Vidlis\LastFmBundle\LastFm\Artist\Album as ArtistAlbum;

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
     * @ArtistQuery
     */
    private $artistQuery;

    /**
     * @param Info $serviceArtistInfo
     * @param ArtistAlbum $serviceArtistAlbum
     * @param AlbumInfo $serviceAlbumInfo
     * @param $doctrineMongoDB
     */
    public function __construct(ArtistInfo $serviceArtistInfo, ArtistAlbum $serviceArtistAlbum,  AlbumInfo $serviceAlbumInfo, $doctrineMongoDB)
    {
        $this->serviceAlbumInfo = $serviceAlbumInfo;
        $this->serviceArtistAlbum = $serviceArtistAlbum;
        $this->serviceArtistInfo = $serviceArtistInfo;
        $this->artistQuery = new ArtistQuery($doctrineMongoDB->getManager());
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
        $result = $this->serviceArtistInfo->setArtist($this->artistName)->getResults();
        if (!isset($result->error)) {
            $artist = new Artist();
            $artist->setName($this->artistName)->setInfo($result->artist->bio->summary);
            if (!is_array($result->artist->tags->tag)) {
                $tags = array($result->artist->tags->tag);
            } else {
                $tags = $result->artist->tags->tag;
            }
            foreach ($tags as $tagResult) {
                $tag = new ArtistTagDocument();
                $tag->setName($tagResult->name);
                $artist->addTag($tag);
            }

            $albumResult = $this->serviceArtistAlbum->setArtist($this->artistName)->getResults();
            if (!isset($albumResult->error)) {
                if (!is_array($albumResult->topalbums->album)) {
                    $albums = array($albumResult->topalbums->album);
                } else {
                    $albums = $albumResult->topalbums->album;
                }
                foreach ($albums as $albumResult) {
                    $album = new ArtistAlbumDocument();
                    $album->setName($albumResult->name)->setMbid($albumResult->mbid);
                    if ($albumResult->mbid) {
                        $albumInfoResult = $this->serviceAlbumInfo->setArtist($this->artistName)->setMbid($albumResult->mbid)->getResults();
                        if (!isset($albumInfoResult->error)) {
                            if (!is_array($albumInfoResult->album->tracks->track)) {
                                $tracks = array($albumInfoResult->album->tracks->track);
                            } else {
                                $tracks = $albumInfoResult->album->tracks->track;
                            }
                            foreach ($tracks as $trackResult) {
                                $track = new ArtistTrackDocument();
                                $track->setName($trackResult->name)->setDuration($trackResult->duration);
                                $album->addTrack($track);
                            }
                        }
                        $artist->addAlbum($album);
                    }
                }
            }
            $this->artistQuery->persist($artist);
        }
    }

}