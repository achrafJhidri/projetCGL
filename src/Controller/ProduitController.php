<?php


namespace App\Controller;


use App\Entity\Fourniture;
use App\Entity\Gamme;
use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
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
     * @return Response
     * @Route ("", name="index_produits")
     */
    public function indexAction(): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $this->em->getRepository(Produit::class)->findAll()
        ]);
    }

    /**
     * @param int $id
     * @Route("/{id}",name="show_produit",requirements={"id"="\d+"})
     * @return Response
     */
    public function showProduit (int $id): Response
    {

        $produit = $this->em->getRepository(Produit::class)->find($id);

        return $this->render('produit/show.html.twig',[
            'produit' => $produit
        ]);
    }

    /**
     * @Route("/create",name="produit_create" , methods={"POST", "GET"}, options={"expose"=true})
     * @param Request $request
     * @return Response
     */
    public function  createProduit(Request $request) :Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class,$produit);

        if ($request->isXmlHttpRequest())
        {
            $produitName = $request->request->get("name");
            $produit->setName($produitName);
            $produit->setSellPrice($request->request->get("price"));

            $gamme = $this->em->getRepository(Gamme::class)->find($request->request->get("gamme"));
            $gamme->addProduct($produit);

            $produitFourniture = json_decode($request->request->get("fournitureProduit"));
            foreach ($produitFourniture as $value)
            {
                $fourniture = $this->em->getRepository(Fourniture::class)->find(intval($value->id_fourniture));
                $produit->addFourniture($fourniture, intval($value->quantite));
            }
            $this->em->persist($produit);
            $this->em->flush();

            $getProduit = $this->em->getRepository(Produit::class)->findOneBy(['name'=> $produitName]);
            //dump($getProduit->getProduitFournitures()->getValues());

            //préparer la reponse
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
            );
            //dump(json_encode($response));
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

}