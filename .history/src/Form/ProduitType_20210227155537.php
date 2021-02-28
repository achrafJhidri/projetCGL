<?php


namespace App\Form;


use App\Entity\Gamme;
use App\Entity\Produit;
use App\Entity\Fourniture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "required"=> true
            ])
            ->add('sellPrice', MoneyType::class, [
                "required"=> true
            ])
            ->add('gamme', EntityType::class, [
                'class' => Gamme::class,
                'choice_label' => 'name',
            ])
            ->add('produitFournitures', EntityType::class, [
                'class'=> Fourniture::class,
                'attr'=
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