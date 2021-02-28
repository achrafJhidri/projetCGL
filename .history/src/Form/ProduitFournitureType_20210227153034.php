<?php


namespace App\Form;


use App\Entity\Fourniture;
use App\Entity\Produit;
use App\Entity\ProduitFourniture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitFournitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'name',
            ])
            ->add('fourniture', EntityType::class, [
                'class' => Fourniture::class,
                'choice_label' => 'name',
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProduitFourniture::class,
        ]);
    }
}