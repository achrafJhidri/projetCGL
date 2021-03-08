<?php

namespace App\Controller;

use App\Entity\Gamme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Undocumented class
 */
class HomeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * HomeController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @return Response
     * @Route("/", name="app_home")
     */
    public function indexAction(): Response
    {
        $gammes = $this->em->getRepository(Gamme::class)->getLastThree();
        $nbGamme = $this->em->getRepository(Gamme::class)->findAll();

        return $this->render("home/index.html.twig", [
            'accueilActif' => 'active',
            'gammes' => $gammes,
            'nbGammes' => count($nbGamme)
        ]);
    }
}
