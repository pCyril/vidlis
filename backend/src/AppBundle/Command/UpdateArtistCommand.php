<?php
namespace AppBundle\Command;


use AppBundle\Entity\Artist;
use AppBundle\Repository\ArtistRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Document\ArtistQuery;

class UpdateArtistCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('update:artist')
            ->setDescription('Recherche automatiquement pour les nouveaux artistes les vidéos YouTube associés');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        /** @var ArtistRepository $artistRepository */
        $artistRepository = $em->getRepository('AppBundle:Artist');

        /** @var Artist[] $artists */
        $artists = $artistRepository->findAll();
        foreach ($artists as $artist) {
            if (count($artist->getAlbums()) == 0) {
                $artist->setDisabled(false);
                $em->persist($artist);
            }
        }
    }
}