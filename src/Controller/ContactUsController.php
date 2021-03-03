<?php


namespace App\Controller;

use App\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactUsController
 * @package App\Controller
 * @Route("/contactus")
 */
class ContactUsController extends AbstractController
{
    /**
     * @param \Swift_Mailer $mailer
     * @param Request $request
     * @return Response
     * @Route ("",name="contactUs")
     */
    public function indexAction(\Swift_Mailer $mailer,Request $request): Response
    {
        $form = $this->createForm(MailType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $email = (new \Swift_Message($form->get('subject')->getData()))
                ->setFrom($form->get('from')->getData())
                ->setTo('achrafjh@gmail.com')

                ->setBody($form->get('content')->getData(),'text/html');


                $mailer->send($email);
                $this->addFlash('succesMail',"Votre mail a été bien envoyé, Merci pour votre contribution");
                return $this->redirectToRoute('app_home');


        }
        return $this->render('home/contactUs.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}