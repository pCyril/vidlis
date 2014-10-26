<?php
namespace Vidlis\CoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Vidlis\LastFmBundle\Document\ArtistQuery;

class UpdateArtistCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('update:artist')
            ->setDescription('Recherche automatiquement pour les nouveaux artistes les vidéos YouTube associés');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $artistQuery = new ArtistQuery($this->getContainer()->get('doctrine_mongodb')->getManager());
        $artists = $artistQuery->notProcessed()->getList();
        foreach ($artists as $artist) {
            if (count($artist->getAlbums()) == 0) {
                $artist->setDisabled();
                $artistQuery->persist($artist);
            }
        }
    }
}