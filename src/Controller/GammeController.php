<?php


namespace App\Controller;


use App\Entity\Gamme;

use App\Entity\Produit;
use App\Form\GammeType;
use ContainerDryPwzK\PaginatorInterface_82dac15;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * @Route("", name="index_gamme")
     */
    public function indexAction(PaginatorInterface $paginator, Request $request)
    {
        $pagination =  $this->em->getRepository(Gamme::class)->getAllWithPagination($paginator,$request->query->getInt('page', 1));

        return $this->render('gamme/index.html.twig',['pagination'=>$pagination]);
    }

    /**
     * @return Response
     * @Route("/create", name="create_gamme")
     * @IsGranted("ROLE_ADMIN")
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
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param int $idGamme
     * @return Response
     * @Route("/{idGamme}", name="show_one_gamme")
     */
    public function showAction(PaginatorInterface $paginator, Request $request, int $idGamme)
    {
        $pagination =  $this->em->getRepository(Produit::class)->findAllProductsByGammeId($paginator,$request->query->getInt('page', 1),$idGamme);

       return $this->render('gamme/show.html.twig',[
            'gamme' => $this->em->getRepository(Gamme::class)->find($idGamme),
            'pagination'=>$pagination
        ]);
    }

    /**
     * @Route("/{id}/edit", name="gamme_edit", requirements={"id":"\d+"})
     * @IsGranted("ROLE_ADMIN")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function editAction(int $id,Request $request): Response
    {
        $gamme = $this->getDoctrine()
            ->getRepository(Gamme::class)
            ->find($id);

        if (!$gamme) {
            throw $this->createNotFoundException(
                'No fourniture found for id '.$id
            );
        }

        $form = $this->createForm(GammeType::class,$gamme);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($gamme);
            $this->em->flush();
            return $this->redirectToRoute('index_gamme');
        }

        return $this->render('gamme/edit.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/{id}/delete", name="gamme_remove", requirements={"id":"\d+"})
     * @IsGranted("ROLE_ADMIN")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function removeAction(int $id,Request $request): Response
    {
        $gamme = $this->getDoctrine()
            ->getRepository(Gamme::class)
            ->find($id);

        $this->em->remove($gamme);
        $this->em->flush();
        return $this->redirectToRoute('index_gamme');
    }

}