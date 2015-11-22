<?php
namespace Vidlis\CoreBundle\Entity;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
use Vidlis\CoreBundle\Entity\AbstractQuery;

class PlayedQuery extends AbstractQuery
{
    private $unreadQueryBuilder;

    private $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
        $this->em = $entityManager;
        $this->unreadQueryBuilder = $entityManager->createQueryBuilder();
        $this->cacheResults(true);
        $this->queryBuilder
            ->select('p')
            ->from('VidlisCoreBundle:Played', 'p');
    }

    /**
     * @param $limit
     * @param UserInterface $user
     * @return Played[]
     */
    public function getLastPlayed($limit, $user = null)
    {
        $this->queryBuilder = $this->em->createQueryBuilder();
        $this->queryBuilder
            ->select('p', 'MAX(p.datePlayed) as dateMax')
            ->from('VidlisCoreBundle:Played', 'p')
            ->addGroupBy('p.idVideo')
            ->orderBy('dateMax', 'DESC');

        $keyCache = 'video_played';
        if (null !== $user) {
            $this->queryBuilder->andWhere('p.user = :user')->setParameter('user', $user);
            $keyCache = 'video_played_' . $user->getUsernameCanonical();
        }
        $this->setLimit($limit)
            ->setLifetime(30);
        return $this->getList($keyCache);
    }

    public  function prePersist($entity)
    {
    }

    public function preRemove($entity)
    {
    }
}
