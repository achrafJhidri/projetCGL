<?php


namespace App\Controller;


use App\Entity\Fourniture;
use App\Entity\Gamme;
use App\Entity\Produit;
use App\Entity\ProduitFourniture;
use App\Form\ProduitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
     * @Route ("/", name="index_produits")
     */
    public function indexAction(): Response
    {
        $produit =  $this->em->getRepository(Produit::class)->find(16);

        return $this->render('produit/index.html.twig', [
            'produits' => $this->em->getRepository(Produit::class)->findAll()
        ]);
    }

    /**
     * @param int $id
     * @Route("/{id}",name="show_produit",requirements={"id"="\d+"})
     */
    public function showProduit (int $id){

        $produit = $this->em->getRepository(Produit::class)->find($id);

//        $tab = $this->em->getRepository(ProduitFourniture::class)->getFournituresForProduct($id);

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
//            $produit->setGamme($gamme);

            $gamme->addProduct($produit);

            $produitFourniture = json_decode($request->request->get("fournitureProduit"));
            foreach ($produitFourniture as $value)
            {
                $fourniture = $this->em->getRepository(Fourniture::class)->find(intval($value->id_fourniture));
                $produit->addFourniture($fourniture, intval($value->quantite));
            }
            $this->em->persist($produit);
            $this->em->flush();

            $encoders = new JsonEncoder();
            $defaultContext = [
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                    return $object->getName();
                },
            ];
            $normalizers = new ObjectNormalizer(null, null,
                null, null, null,
                null, $defaultContext);

            $serializer = new Serializer([$normalizers], [$encoders]);
            $getProduit = $this->em->getRepository(Produit::class)->findOneBy(['name'=> $produitName]);
            //dump($serializer->serialize($getProduit, 'json'));
            return new JsonResponse($serializer->serialize($getProduit, 'json'));
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