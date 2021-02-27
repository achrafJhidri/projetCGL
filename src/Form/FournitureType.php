<?php


namespace App\Form;


use App\Entity\Fourniture;
use App\Entity\Gamme;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournitureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fournitures', EntityType::class, [
                'class' => Fourniture::class,
                'choice_label' => 'name',
                'mapped'=>false,
                'multiple'=>true
            ])
            ->add('quantity', MoneyType::class, [
                "required"=> true,
                'mapped' => false
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}