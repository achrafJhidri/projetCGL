<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ConfigController
 * @package App\Controller
 * @Route("/config")
 *
 */
class ConfigController extends AbstractController
{
    /**
     * @Route("",name="config_index")
     */
    public function indexAction(){

        return $this->render("home/config.html.twig");
    }
}