<?php


namespace App\Form;


use App\Entity\Gamme;
use App\Entity\Produit;
use App\Entity\ProduitFourniture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add(
                $builder->create('produitFournitures', ProduitFourniture::class);
            )
            ->add('save', SubmitType::class, ['label' => 'Créer votre produit'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}