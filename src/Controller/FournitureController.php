<?php


namespace App\Controller;


use App\Entity\Fourniture;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/create",name="fourniture_create",methods={"POST"})
     */
    public function  createFourniture() :Response   {
        $em = $this->getDoctrine()->getManager();

        $fourniture = new Fourniture();
        $fourniture->setName("carton");
        $fourniture->setBuyPrice(2.23);
        $fourniture->setIsPriceUpdatable(true);

        $em->persist($fourniture);
        $em->flush();
        return new Response("saved new fourniture with id ".$fourniture->getId());
    }

    /**
     * @Route("/fourniture/{id}", name="fourniture_show_byId")
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

        return new Response('Check out this great fourniture: '.$fourniture->getName());

        // or render a template
        // in the template, print things with {{ fourniture.name }}
        // return $this->render('fourniture/show.html.twig', ['fourniture' => $fourniture]);
    }

    /**
     * @Route("/", name="index_fournitures", methods={"GET"})
     */
    public function indexAction(): Response
    {
         $fournitures = $this->getDoctrine()
            ->getRepository(Fourniture::class)
            ->findAll();

         return $this->render('fourniture/index.html.twig',['fournitures' => $fournitures]);

    }



}