<?php


namespace App\Form;


use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('subject', TextType::class, [
                "label"=> "Titre",
                'attr'=> ['class'=> 'form-control mb-2']
            ])
            ->add('content', CKEditorType::class, [
                "label"=> "message",
                'attr'=> ['class'=> 'form-control mb-2']
            ])
            ->add('envoyer', SubmitType::class, [
                'attr'=>['class'=>'btn btn-primary mt-3']
            ])
        ;
    }


}