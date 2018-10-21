<?php
namespace AppBundle\Command;


use AppBundle\Entity\Artist;
use AppBundle\Repository\ArtistRepository;
use AppBundle\Youtube\YoutubeSearch;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateTrackCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('vidlis:update:track')
            ->setDescription('Recherche automatiquement pour les nouveaux artistes les vidéos YouTube associés');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        /** @var ArtistRepository $artistRepository */
        $artistRepository = $em->getRepository('AppBundle:Artist');
        /** @var YoutubeSearch $youtubeSearch */
        $youtubeSearch = $this->getContainer()->get('youtubeSearch');

        /** @var Artist[] $artists */
        $artists = $artistRepository->findBy(['processed' => false], [], 5);


        $bar = new ProgressBar($output, count($artists));
        $bar->setFormat('Artists processed: %current%/%max% [%bar%] : (%percent%%) %elapsed:6s% %memory%');

        $bar->start();

        foreach ($artists as $artist) {
            if ($artist->getName() != '[unknown]') {
                if (count($artist->getAlbums())) {
                    foreach ($artist->getAlbums() as $album) {
                        foreach ($album->getTracks() as $track) {
                            $result = $youtubeSearch->setQuery($artist->getName(). ' - '. $track->getName())->getResults();
                            if(isset($result['items'])) {
                                foreach ($result['items'] as $item) {
                                    if (strpos(strtolower($item['snippet']['title']), strtolower($track->getName()))) {
                                        //$output->writeln($item['id']['videoId'] . ' ' . $artist->getName(). ' '. $track->getName());
                                        $track->setYoutubeId($item['id']['videoId']);
                                        if ($this->hasNoInvalidateWords($item['snippet']['title'], $track->getName())) {
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                        $em->flush();
                    }
                } else {
                    $artist->setDisabled(true);
                }
            }
            $bar->advance();
            $artist->setProcessed(true);
        }

        $em->flush();
    }

    /**
     * Check if there words like cover, full album for quality
     *
     * @param $titleFound
     * @param $trackTitle
     * @return bool
     */
    private function hasNoInvalidateWords($titleFound, $trackTitle)
    {
        $words = array('cover', 'full album', 'full', 'reprise', 'complet');
        foreach ($words as $word) {
            if (strpos($trackTitle, $word) === false) {
                if (strpos($titleFound, $word)) {
                    return false;
                }
            }
        }
        return true;
    }
}