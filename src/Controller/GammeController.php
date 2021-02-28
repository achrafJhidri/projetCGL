<?php


namespace App\Controller;


use App\Entity\Gamme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GammeController
 * @package App\Controller
 * @Route("/gammes")
 */
class GammeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * GammeController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return Response
     * @Route("/", name="index_gamme")
     */
    public function indexAction()
    {
        return $this->render('gamme/index.html.twig', [
            'gammes'=> $this->em->getRepository(Gamme::class)->findAll()
        ]);
    }

    /**
     * @param int $id
     * @Route("/{id}", name="show_on_gamme")
     *
     */
    public function showAction(int $id)
    {

    }

}