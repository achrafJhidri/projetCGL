<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AproposController
 * @package App\Controller
 * @Route("/about")
 */
class AproposController extends AbstractController
{
    /**
     * @return Response
     * @Route("", name="about")
     */
    public function indexAction():Response {
        return $this->render("home/apropos.html.twig",[
            'aproposActif'=>'actif'
        ]);
    }
}