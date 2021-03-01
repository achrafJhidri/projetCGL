<?php


namespace App\Repository;


use App\Entity\Fourniture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

class FournitureRepository extends ServiceEntityRepository
{

    /**
     * FournitureRespository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fourniture::class);
    }

    /**
     * @param int $gammeId
     * @return array
     */
    public function findAllFournitureByGamme(int $gammeId) :array
    {
        $qb = $this->createQueryBuilder('f')
            ->select('f.id')
            ->addSelect('f.name')
            ->orderBy('f.name', 'ASC')
            ->where('f.gamme = :gammeId')
            ->setParameter('gammeId',$gammeId)
        ;
        return  $qb->getQuery()->execute();

    }

}