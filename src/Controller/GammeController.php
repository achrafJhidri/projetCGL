<?php


namespace App\Controller;


use App\Entity\Gamme;

use App\Entity\Produit;
use App\Form\GammeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("", name="index_gamme")
     */
    public function indexAction()
    {
        return $this->render('gamme/index.html.twig', [
            'gammes'=> $this->em->getRepository(Gamme::class)->findAll()
        ]);
    }

    /**
     * @return Response
     * @Route("/create", name="create_gamme")
     */
    public function createAction(Request $request)
    {
        $gamme = new Gamme();
        $form = $this->createForm(GammeType::class,$gamme);


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ) {

            $gamme = $form->getData();

            $this->em->persist($gamme);
            $this->em->flush();
            return $this->redirectToRoute("index_gamme");
        }

        return $this->render('gamme/new.html.twig', [
        'form'=> $form->createView(),
            'numberOfGammes' => sizeof($this->em->getRepository(Gamme::class)->findAll())
        ]);
    }

    /**
     * @param int $id
     * @Route("/{id}", name="show_one_gamme")
     *
     */
    public function showAction(int $id)
    {
       return $this->render('gamme/show.html.twig',[
            'gamme' => $this->em->getRepository(Gamme::class)->find($id)
        ]);
    }

}