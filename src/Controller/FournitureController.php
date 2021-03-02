<?php


namespace App\Controller;


use App\Entity\Fourniture;

use App\Form\FournitureType;
use Doctrine\ORM\EntityManagerInterface;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FournitureController
 * @package App\Controller
 * @Route("/fournitures")
 */
class FournitureController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface  $em;

    /**
     * FournitureController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("", name="index_fournitures", methods={"GET"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function indexAction(PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $this->em->getRepository(Fourniture::class)
            ->getAllWithPagination($paginator,$request->query->getInt('page', 1));

        return $this->render('fourniture/index.html.twig', ['pagination' => $pagination]);

    }

    /**
     * @Route("/create",name="fourniture_create")
     * @param Request $request
     * @return Response
     */
    public function  createFourniture(Request $request ) :Response   {
       $fourniture = new Fourniture();
       $form = $this->createForm(FournitureType::class,$fourniture);

       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $this->em->persist($fourniture);
           $this->em->flush();



           return $this->redirectToRoute('index_fournitures');
       }

       $nb = sizeof($this->getDoctrine()->getRepository(Fourniture::class)->findAll());

       return $this->render('fourniture/new.html.twig',[
           'form' => $form->createView(),
           'numberOfFournitures' => $nb,
       ]);
    }

    /**
     * @Route("/{id}", name="fourniture_one_show", requirements={"id":"\d+"})
     */
    public function show(int $id): Response
    {
        $fourniture = $this->getDoctrine()
            ->getRepository(Fourniture::class)
            ->find($id);

        if (!$fourniture) {
            throw $this->createNotFoundException(
                'No fourniture found for id '.$id
            );
        }

        return $this->render('fourniture/show.html.twig',[
            'fourniture' => $fourniture
        ]);


    }



    /**
     * @param Request $request
     * @Route ("/get-fourniture-by-gamme", name="get_fourniture_by_gamme", methods={"GET"}, options={"expose"=true} )
     * @return JsonResponse
     */
    public function getFournitureByGamme(Request $request)
    {
        $response = [];
        if ($request->isXmlHttpRequest()){
            $idGamme = intval($request->headers->get('idGamme')[0]);
            dump($idGamme);
            $listFourniture = $this->em->getRepository(Fourniture::class)->findAllFournitureByGamme($idGamme);
            $response = ['status'=>200, 'data'=> $listFourniture];

            return new JsonResponse(json_encode($response));
        }
        else
        {
            $response = ['status'=>403, 'message'=>'cette route est disponible uniquement pour appelle ajax !'];
            return new JsonResponse(json_encode($response));
        }
    }



}