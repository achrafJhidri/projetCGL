<?php


namespace App\Form\Fourniture;





use App\Entity\Fourniture;
use App\Entity\Gamme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournitureUpdateType extends AbstractType
{
    use FournitureTraitType;
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->buildFormCommun($builder,$options);
        $builder
            ->add('gamme', EntityType::class, [
                'class' => Gamme::class,
                'choice_label' => 'name',
                'attr'=>['class'=>'form-control mb-2'],
                'disabled'=>true
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