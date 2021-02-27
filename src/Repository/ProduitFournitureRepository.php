<?php


namespace App\Repository;

use App\Entity\ProduitFourniture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProduitFournitureRepository extends ServiceEntityRepository
{
    /**
     * ProduitFournitureRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitFourniture::class);
    }
}