<?php


namespace App\Controller;


use App\Entity\Fourniture;
use App\Entity\Gamme;
use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{



    /**
     * @Route("/produittest",name="produit_create_test",methods={"GET"})
     */
    public function  createProduit_test() :Response   {
        $em = $this->getDoctrine()->getManager();

        $fourniture = new Fourniture();
        $fourniture->setName("bimo");
        $fourniture->setBuyPrice(2.23);
        $fourniture->setIsPriceUpdatable(true);

        $gamme = new Gamme();
        $gamme->setName("laa3ala9a");

        $produit = new Produit();
        $produit->setName("pcportable");
        $produit->setGamme($gamme);
        $produit->addFourniture($fourniture,4);
        $pr

//        dump($produit);die;

        $em->persist($produit);
        $em->flush();

        return new Response("saved new fourniture with id ".$produit->getId());
    }


    /**
     * @Route("/produit",name="produit_create")
     */
    public function  createProduit(Request $request) :Response   {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class,$produit);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

//             $fournitures = $form->get('fournitures')->getData();


             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($produit);
             $entityManager->flush();

            return $this->render('produit/show.html.twig', [
                'produit' => $produit,
//                'fournitures'=>$fournitures
            ]);
        }


        return $this->render('produit/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}