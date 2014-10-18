<?php
namespace Vidlis\CoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Vidlis\LastFmBundle\Document\ArtistQuery;

class UpdateTrackCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('update:track')
            ->setDescription('Recherche automatiquement pour les nouveaux artistes les vidéos YouTube associés');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $artistQuery = new ArtistQuery($this->getContainer()->get('doctrine_mongodb')->getManager());
        $youtubeSearch = $this->getContainer()->get('youtubeSearch');
        $artists = $artistQuery->notProcessed()->setLimit(5)->getList();
        foreach ($artists as $artist) {
            if ($artist->getName() != '[unknown]') {
                foreach ($artist->getAlbums() as $album) {
                    foreach ($album->getTracks() as $track) {
                        $result = $youtubeSearch->setQuery($artist->getName(). ' - '. $track->getName())->getResults();
                        if(isset($result->items)) {
                            foreach ($result->items as $item) {
                                if (strpos(strtolower($item->snippet->title), strtolower($track->getName()))) {
                                    $output->writeln($item->id->videoId . ' ' . $artist->getName(). ' '. $track->getName());
                                    $track->setYoutubeId($item->id->videoId);
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            $artist->setProcessed();
            $artistQuery->persist($artist);
        }
    }
}