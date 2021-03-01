<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CalculRentabiliteController
 * @package App\Controller
 * @Route("/calcul-rentabilite")
 */
class CalculRentabiliteController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * CalculRentabiliteController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("", name="index_calcul_rentabilite")
     */
    public function indexAction()
    {
        return $this->render("calculRentabilite/index.html.twig", [

        ]);
    }


}