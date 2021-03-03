<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;


class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('from', EmailType::class, [
                "label"=> "Email",
                'attr'=> ['class'=> 'form-control mb-2']
            ])
            ->add('subject', TextareaType::class, [
                "label"=> "Titre",
                'attr'=> ['class'=> 'form-control mb-2']
            ])
            ->add('content', TextareaType::class, [
                "label"=> "message",
                'attr'=> ['class'=> 'form-control mb-2']
            ])
            ->add('envoyer', SubmitType::class, [
                'attr'=>['class'=>'btn btn-primary']
            ])
        ;
    }


}