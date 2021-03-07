<?php


namespace App\Controller;


use App\Entity\Fourniture;

use App\Form\Fourniture\FournitureUpdateType;
use App\Form\Fourniture\FournitureType;
use Doctrine\ORM\EntityManagerInterface;

use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function  createAction(Request $request ) :Response   {
       $fourniture = new Fourniture();
       $form = $this->createForm(FournitureType::class,$fourniture);

       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $this->em->persist($fourniture);
           $this->em->flush();
           return $this->redirectToRoute('index_fournitures');
       }

       return $this->render('fourniture/new.html.twig',[
           'form' => $form->createView(),
       ]);
    }

    /**
     * @Route("/{id}", name="fourniture_one_show", requirements={"id":"\d+"})
     */
    public function showAction(int $id): Response
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
     * @Route("/{id}/edit", name="fourniture_edit", requirements={"id":"\d+"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editAction(int $id,Request $request): Response
    {
        $fourniture = $this->getDoctrine()
            ->getRepository(Fourniture::class)
            ->find($id);

        if (!$fourniture) {
            throw $this->createNotFoundException(
                'No fourniture found for id '.$id
            );
        }

        $form = $this->createForm(FournitureUpdateType::class,$fourniture);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($fourniture);
            $this->em->flush();
            return $this->redirectToRoute('index_fournitures');
        }

        return $this->render('fourniture/edit.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/{id}/delete", name="fourniture_remove", requirements={"id":"\d+"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function removeAction(int $id,Request $request): Response
    {
        $fourniture = $this->getDoctrine()
            ->getRepository(Fourniture::class)
            ->find($id);

        $this->em->remove($fourniture);
        $this->em->flush();
        return $this->redirectToRoute('index_fournitures');
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