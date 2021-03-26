<?php


namespace App\Repository;

use App\Entity\ProduitFourniture;
use App\Entity\Traits\Constantes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class ProduitFournitureRepository extends ServiceEntityRepository
{
    use Constantes;
    /**
     * ProduitFournitureRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitFourniture::class);
    }

    /**
     * @param int $productId
     * @return array
     */
    public function getFournituresForProduct(int $productId) : array {
        $qb = $this->createQueryBuilder('p')
            ->where('p.product = :productId')
            ->setParameter('productId',$productId);
        ;
        return $qb->getQuery()->execute();
    }

    public function findAlreadySaved(int $productId, int $fournitureId) {
        $qb  = $this->createQueryBuilder('p')
            ->where('p.product = :productId')
            ->andWhere('p.fourniture = :fournitureId')
            ->setParameter('productId',$productId)
            ->setParameter('fournitureId',$fournitureId);
        return $qb->getQuery()->execute();
    }
}