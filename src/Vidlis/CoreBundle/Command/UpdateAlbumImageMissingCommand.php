<?php
namespace Vidlis\CoreBundle\Command;


use Gaufrette\Filesystem;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Vidlis\LastFmBundle\Document\ArtistQuery;
use Vidlis\LastFmBundle\LastFm\Artist\Album;

class UpdateAlbumImageMissingCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('update:image')
            ->setDescription('Store images in local');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var LoggerInterface $logger */
        $logger = $this->getContainer()->get('logger');
        $artistQuery = new ArtistQuery($this->getContainer()->get('doctrine_mongodb')->getManager());
        /** @var Album $lastFmArtistAlbumService */
        $lastFmArtistAlbumService = $this->getContainer()->get('lastFmArtistAlbum');
        $artists = $artistQuery->getList();
        foreach ($artists as $artist) {
            if ($artist->getName() != '[unknown]') {
                $logger->info(sprintf('Start process for artist: %s', $artist->getName()));
                foreach ($artist->getAlbums() as $album) {
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
                                    if ('' !== $image->$var) {
                                        /** @var Filesystem $fileSystem */
                                        $fileSystem = $this->getContainer()->get('knp_gaufrette.filesystem_map')->get('local');
                                        $fileName = substr($image->$var, strrpos($image->$var, '/'));
                                        $fileSystem->write($fileName, file_get_contents($image->$var));
                                        $album->setImage($fileName);
                                        break;
                                    } else {
                                        $album->setImage('');
                                    }
                                }
                            }
                        }
                    }
                }
                $logger->info(sprintf('End process for artist: %s', $artist->getName()));
                $artistQuery->persist($artist);
            }
        }
    }
}
