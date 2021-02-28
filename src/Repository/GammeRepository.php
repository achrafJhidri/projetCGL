<?php


namespace App\Repository;


use App\Entity\Gamme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class GammeRepository extends ServiceEntityRepository
{

    /**
     * GammeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gamme::class);
    }

    /**
     * @return array|null
     */
    public function getLastThree() : ?array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p.id, p.name')
            ->orderBy('p.id', 'DESC')
        ;
        $query = $qb->getQuery();
        return $query->setMaxResults(3)->execute();

    }
}