<?php


namespace App\Form\Fourniture;





use App\Entity\Fourniture;
use App\Entity\Gamme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournitureUpdateType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //TODO refactor with FournitureType only disabled=true is changed
        $builder
            ->add('name', TextType::class, [
                "label"=> "Nom de la fourniture",
                'attr'=>['class'=>'form-control mb-2']

            ])
            ->add('gamme', EntityType::class, [
                'class' => Gamme::class,
                'choice_label' => 'name',
                'attr'=>['class'=>'form-control mb-2'],
                'disabled'=>true
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
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fourniture::class,
        ]);
    }
}