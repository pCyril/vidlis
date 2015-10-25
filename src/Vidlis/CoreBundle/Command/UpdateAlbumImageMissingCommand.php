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
        $artistQuery = new ArtistQuery($this->getContainer()->get('doctrine_mongodb')->getManager());
        /** @var Album $lastFmArtistAlbumService */
        $lastFmArtistAlbumService = $this->getContainer()->get('lastFmArtistAlbum');
        /** @var Filesystem $fileSystem */
        $fileSystem = $this->getContainer()->get('knp_gaufrette.filesystem_map')->get('local');
        $artists = $artistQuery->addOrderBy('name')->getList();
        foreach ($artists as $artist) {
            if ($artist->getName() != '[unknown]') {
                $output->writeln(sprintf('Start process for artist: %s', $artist->getName()));
                foreach ($artist->getAlbums() as $album) {
                    if ($fileSystem->has($album->getImage()) || $album->getImage() === '') {
                        continue;
                    }
                    $output->writeln(sprintf('Image doesn\'t exist for album: %s', $album->getName()));
                    $albumResult = $lastFmArtistAlbumService->setArtist($artist->getName())->getResults();
                    if (!isset($albumResult->error) && isset($albumResult->topalbums->album)) {
                        if (!is_array($albumResult->topalbums->album)) {
                            $albums = array($albumResult->topalbums->album);
                        } else {
                            $albums = $albumResult->topalbums->album;
                        }
                        $found = false;
                        foreach ($albums as $albumResult) {
                            if ($album->getName() == $albumResult->name) {
                                if (is_array($albumResult->image)) {
                                    $image = $albumResult->image[count($albumResult->image) - 1];
                                    $var = '#text';
                                    if ('' !== $image->$var) {
                                        $fileName = substr($image->$var, strrpos($image->$var, '/'));
                                        $fileSystem->write($fileName, file_get_contents($image->$var), true);
                                        $album->setImage($fileName);
                                        $found = true;
                                        break;
                                    } else {
                                        $album->setImage('');
                                    }
                                }
                            }
                        }
                        if (!$found) {
                            $output->writeln(sprintf('Album not found: %s', $album->getName()));
                            $album->setImage('');
                        }
                    } else {
                        $album->setImage('');
                        $output->writeln(sprintf('Fail to get information for album: %s', $album->getName()));
                    }
                }
                $output->writeln(sprintf('End process for artist: %s', $artist->getName()));
                $artistQuery->persist($artist);
            }
        }
    }
}
