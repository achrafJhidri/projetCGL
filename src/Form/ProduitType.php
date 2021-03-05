<?php


namespace App\Form;


use App\Entity\Gamme;
use App\Entity\Produit;
use App\Entity\Fourniture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
class ProduitType extends AbstractType
{
    private  $idFirstGamme;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label"=> "Nom du produit",
                'attr'=> ['class'=> 'form-control mb-2']
            ])
            ->add('sellPrice', NumberType::class, [
                'html5'=>true,
                'label'=>'Prix du produit',
                'scale' => 2,
                'attr' => array(
                    'placeholder' => 'x.xx',
                    'class' => 'form-control mb-2'
                ),
            ])
            ->add('gamme', EntityType::class, [
                'class' => Gamme::class,
                'choice_label' => 'name',
                'label' => 'Gamme d\'appartenance',
                'attr' => ['class'=> 'form-control mb-2'],
                'query_builder' => function (EntityRepository  $entityManager) {
                    $query = $entityManager->createQueryBuilder('g')
                        ->orderBy('g.id', 'ASC')
                        ->setMaxResults(1)
                    ;
                    $gamme=  $query->getQuery()->execute();
                    $this->idFirstGamme = $gamme[0]->getId();
                },
            ])
            ->add('produitFournitures', EntityType::class, [
                'class'=> Fourniture::class,
                'label'=> 'Fournitures',
                'attr'=> ['class'=>'form-control mb-2'],
                'query_builder' => function (EntityRepository  $entityManager) {
                    return $entityManager->createQueryBuilder('f')
                        ->where('f.gamme='.$this->idFirstGamme)
                        ->orderBy('f.name', 'ASC');
                },
            ])
            ->add('Sauvegarder', SubmitType::class, [
                'attr'=>['class'=>'btn btn-primary']
            ])
        ;
    }

}