<?php


namespace App\Repository;

use App\Entity\Produit;
use App\Entity\Traits\Constantes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class ProduitRepository extends ServiceEntityRepository
{
    use Constantes;
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
    public function getAllWithPagination(PaginatorInterface $paginator,int $pageNumber ) : PaginationInterface
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.id','DESC')
            ->getQuery();

        return $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $pageNumber, /*page number*/
            self::$RESULT_NUMBER/*limit per page*/
        );
    }
    public function findAllProductsByGammeId(PaginatorInterface $paginator,int $pageNumber, int $idGamme) : PaginationInterface
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.gamme = :id')
            ->setParameter('id',$idGamme)
            ->getQuery();

        return $pagination = $paginator->paginate(
            $query,
            $pageNumber,
            self::$RESULT_NUMBER
        );
    }
    public function findAllFournituresByProduitId(PaginatorInterface $paginator,int $pageNumber,int $produitId)  : PaginationInterface
    {
        $query = $this->createQueryBuilder('p')
            ->where('p = :productId')
            ->setParameter('productId',$produitId)
            ->getQuery();

        return $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $pageNumber, /*page number*/
            self::$RESULT_NUMBER/*limit per page*/
        );

    }
}