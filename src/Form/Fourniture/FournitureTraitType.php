<?php


namespace App\Form\Fourniture;


use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

trait FournitureTraitType
{
    public function buildFormCommun (FormBuilderInterface $builder, array $options){
    $builder
        ->add('name', TextType::class, [
            "label"=> "Nom de la fourniture",
            'attr'=>['class'=>'form-control mb-2']

        ])
        ->add("buyPrice",NumberType::class,[
            'html5'=>true,
            "label"=> "prix d'achat",
            'attr'=>[
                'class'=>'form-control',
                'placeholder' => 'x.xx',
            ]
        ])
        ->add('isPriceUpdatable',CheckboxType::class,[
            "label"=> 'prix modifiable',
            'required'=>false,
            'attr'=>['class'=>'form-check-input'],
            'label_attr'=>['class'=> 'form-check-label mr-4']
        ])

        ->add('enregistrer', SubmitType::class, [
            'attr'=>['class'=>'btn btn-primary'],
        ])
    ;
}
}