<?php


namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class ProduitRepository extends ServiceEntityRepository
{
    /**
     * ProduitRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
     * @return Produit|null
     */
    public function getLastRow() : ?Produit
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC');
        $query = $qb->getQuery();
        try {
            return $query->setMaxResults(1)->getOneOrNullResult();
        }catch (NonUniqueResultException $e) {
            return null;
        }
    }
    /**
     * @return array
     */
    public function getProduitsByGamme(int $gammeId) :array
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->where('p.gamme = :gammeId')
            ->setParameter('gammeId',$gammeId)
                ;
        return  $qb->getQuery()->execute();

    }
}