<?php


namespace App\Form;


use App\Entity\Fourniture;
use App\Entity\Gamme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournitureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label"=> "Nom de la fourniture",

            ])
            ->add('gamme', EntityType::class, [
                'class' => Gamme::class,
                'choice_label' => 'name',

            ])
            ->add("buyPrice",MoneyType::class,[
                "label"=> "prix d'achat"
            ])
            ->add('isPriceUpdatable',CheckboxType::class,[
                "label"=> 'prix modifiable ?'
            ])

            ->add('Sauvegarder la fourniture', SubmitType::class, [
                'attr'=>['class'=>'btn btn-primary']
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