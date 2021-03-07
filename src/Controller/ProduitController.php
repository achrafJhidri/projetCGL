<?php


namespace App\Controller;


use App\Entity\Fourniture;
use App\Entity\Gamme;
use App\Entity\Produit;
use App\Entity\ProduitFourniture;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProduitController
 * @package App\Controller
 * @Route("/produits")
 */

class ProduitController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * ProduitController constructor.
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * @Route ("", name="index_produits")
     */
    public function indexAction(PaginatorInterface $paginator, Request $request)
    {
        $pagination =  $this->em->getRepository(Produit::class)->getAllWithPagination($paginator,$request->query->getInt('page', 1));
        return $this->render('produit/index.html.twig',['pagination'=>$pagination]);
    }

    /**
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param int $id
     * @return Response
     * @Route("/{id}",name="show_produit",requirements={"id"="\d+"})
     */
    public function showAction(PaginatorInterface $paginator, Request $request,int $id): Response
    {
        $pagination =  $this->em->getRepository(Produit::class)
            ->findAllFournituresByProduitId($paginator,$request->query->getInt('page', 1),$id);

        $produit = $this->em->getRepository(Produit::class)->find($id);

        return $this->render('produit/show.html.twig',[
            'produit' => $produit,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/create",name="produit_create" , methods={"POST", "GET"})
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return Response
     */
    public function  createAction(Request $request) :Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class,$produit);

        if ($request->isXmlHttpRequest())
        {
            $produitName = $this->productHandler($produit, $request, true);
            $getProduit = $this->em->getRepository(Produit::class)->findOneBy(['name'=> $produitName]);

            $produitFournitures = [];
            foreach ($getProduit->getProduitFournitures()->getValues() as $element){
                array_push($produitFournitures, ["quantite"=>$element->getQuantite(),
                    'fourniture'=>['name'=> $element->getFourniture()->getName()]]);
            }
            $response = array(
                'id' => $getProduit->getId(),
                'name'=> $getProduit->getName(),
                'sellPrice'=>$getProduit->getSellPrice(),
                'gamme'=>['name'=>$getProduit->getGamme()->getName()],
                'produitFournitures'=> $produitFournitures,
                'status'=> 201,
                'message'=>'Le produit '.$produitName.' a bien été créé.'
            );
            return new JsonResponse(json_encode($response));
        }
        else
        {
            return $this->render('produit/new.html.twig', [
                'form' => $form->createView(),
                'produits'=> $this->em->getRepository(Produit::class)->findAll(),
                'derniersProduits'=> $this->em->getRepository(Produit::class)->getLastRow()
            ]);
        }
    }

    /**
     * @Route("/{id}/edit", name="produit_edit", requirements={"id":"\d+"}, methods={"POST", "GET"})
     * @IsGranted("ROLE_ADMIN")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function editAction(int $id , Request $request): Response
    {
        $produit = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->find($id);

        if (!$produit) {
            throw $this->createNotFoundException(
                'No produit found for id '.$id
            );
        }

        $form = $this->createForm(ProduitType::class,$produit);

        if ($request->isXmlHttpRequest()) {
           $produitName = $this->productHandler($produit, $request);

           $this->addFlash('success', 'Le produit '.$produitName.' a bien été modifié.');
           return new JsonResponse(json_encode(['status'=>200, 'message'=>'Le produit '.$produitName.' a bien été modifié.']));
        }

        return $this->render('produit/edit.html.twig',[
            'form'=>$form->createView() ,
            'produit'=>$produit
        ]);
    }

    /**
     * @Route("/{id}/delete", name="produit_remove", requirements={"id":"\d+"})
     * @IsGranted("ROLE_ADMIN")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function removeAction(int $id,Request $request): Response
    {
        $produit = $this->getDoctrine()
            ->getRepository(Produit::class)
            ->find($id);

        $this->em->remove($produit);
        $this->em->flush();
        return $this->redirectToRoute('index_fournitures');
    }

    private function productHandler(Produit $produit, Request  $request, $created=false): string
    {
        $produitName = $request->request->get("name");
        $produit->setName($produitName);
        $produit->setSellPrice(floatval($request->request->get("price")));

        $gamme = $this->em->getRepository(Gamme::class)->find($request->request->get("gamme"));
        $gamme->addProduct($produit);

        $produitFourniture = json_decode($request->request->get("fournitureProduit"));
        foreach ($produitFourniture as $value)
        {
            $fournitureId = intval($value->id_fourniture) ;

            if(!$created){
                $savedPF = $this->em->getRepository(ProduitFourniture::class)->findAlreadySaved($produit->getId(),$fournitureId);
                if($savedPF && $savedPF[0]){
                    $this->em->remove($savedPF[0]);
                    $this->em->flush();
                }
            }

            $fourniture = $this->em->getRepository(Fourniture::class)->find($fournitureId);
            $produit->addFourniture($fourniture, intval($value->quantite));
        }
        if($created){
            $this->em->persist($produit);
        }
        $this->em->flush();

        return $produit->getName();
    }

}