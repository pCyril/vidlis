<?php
namespace Vidlis\CoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Vidlis\LastFmBundle\Document\ArtistQuery;

class UpdateAlbumImageMissingCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('update:image')
            ->setDescription('Récupère les images des albums que je n\'ai pas récupérer tout de suite ...');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $artistQuery = new ArtistQuery($this->getContainer()->get('doctrine_mongodb')->getManager());
        $lastFmArtistAlbumService = $this->getContainer()->get('lastFmArtistAlbum');
        $artists = $artistQuery->getList();
        foreach ($artists as $artist) {
            if ($artist->getName() != '[unknown]') {
                foreach ($artist->getAlbums() as $album) {
                    if ($album->getImage() == '') {
                        $albumResult = $lastFmArtistAlbumService->setArtist($artist->getName())->getResults();
                        if (!isset($albumResult->error) && isset($albumResult->topalbums->album)) {
                            if (!is_array($albumResult->topalbums->album)) {
                                $albums = array($albumResult->topalbums->album);
                            } else {
                                $albums = $albumResult->topalbums->album;
                            }
                            foreach ($albums as $albumResult) {
                                if ($album->getName() == $albumResult->name) {
                                    if (is_array($albumResult->image)) {
                                        $image = $albumResult->image[count($albumResult->image) - 1];
                                        $var = '#text';
                                        $album->setImage($image->$var);
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
                $artistQuery->persist($artist);
            }
        }
    }
}
