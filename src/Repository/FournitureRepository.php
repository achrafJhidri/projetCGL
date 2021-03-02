<?php


namespace App\Repository;


use App\Entity\Fourniture;
use App\Entity\Traits\Constantes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class FournitureRepository extends ServiceEntityRepository
{
    use Constantes;
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

    public function getAllWithPagination(PaginatorInterface $paginator,int $pageNumber ) : PaginationInterface
    {
        $query = $this->createQueryBuilder('f')
            ->orderBy('f.id','DESC')
            ->getQuery();

        return $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $pageNumber, /*page number*/
            self::$RESULT_NUMBER/*limit per page*/
        );
    }


}