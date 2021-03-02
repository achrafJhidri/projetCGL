<?php


namespace App\Repository;


use App\Entity\Gamme;
use App\Entity\Traits\Constantes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class GammeRepository extends ServiceEntityRepository
{

    use Constantes;
    /**
     * GammeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gamme::class);
    }

    public function getAllWithPagination(PaginatorInterface $paginator,int $pageNumber ) : PaginationInterface
    {
        $query = $this->createQueryBuilder('g')
            ->orderBy('g.id','DESC')
            ->getQuery();

        return $pagination = $paginator->paginate(
            $query,
            $pageNumber,
            self::$RESULT_NUMBER
        );
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