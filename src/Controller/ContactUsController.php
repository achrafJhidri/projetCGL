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
     * @param MailerInterface $mailer
     * @param Request $request
     * @return Response
     * @Route ("",name="contactUs")
     */
    public function indexAction(MailerInterface $mailer,Request $request): Response
    {
        $form = $this->createForm(MailType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $email = (new Email())
                ->from($form->get('from')->getData())
                ->to('achrafjh@gmail.com')
                ->priority(Email::PRIORITY_HIGH)
                ->subject($form->get('subject')->getData())
                ->text($form->get('content')->getData());

            try {
                $mailer->send($email);
                return $this->redirectToRoute('app_home');

            } catch (TransportExceptionInterface $e) {
                dump($e);die;
            }
        }
        return $this->render('home/contactUs.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}