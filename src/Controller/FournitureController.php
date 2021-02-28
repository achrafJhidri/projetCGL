<?php


namespace App\Controller;


use App\Entity\Fourniture;

use App\Form\FournitureType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/create",name="fourniture_create")
     */
    public function  createFourniture(Request $request ) :Response   {
       $fourniture = new Fourniture();
       $form = $this->createForm(FournitureType::class,$fourniture);

       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           $this->em->persist($fourniture);
           $this->em->flush();

           return $this->render( 'fourniture/show.html.twig',[
               'fourniture'=>$fourniture
           ]);
       }

       $nb = sizeof($this->getDoctrine()->getRepository(Fourniture::class)->findAll());

       return $this->render('fourniture/new.html.twig',[
           'form' => $form->createView(),
           'numberOfFournitures' => $nb,
       ]);
    }

    /**
     * @Route("/{id}", name="fourniture_one_show")
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