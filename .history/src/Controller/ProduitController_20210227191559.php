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
        $fourniture->setName("fourniture1");
        $fourniture->setBuyPrice(2.23);
        $fourniture->setIsPriceUpdatable(true);

        $gamme = new Gamme();
        $gamme->setName("Gamme 2");

        $produit = new Produit();
        $produit->setName("produit 1");
        $produit->setGamme($gamme);
        $produit->addFourniture($fourniture,4);
        $produit->setSellPrice(10);

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
        dum
        return $this->render('produit/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}