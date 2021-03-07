<?php


namespace App\DataFixtures;


use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProduitFixture extends Fixture  implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $produit = new Produit();
        $produit->setName("Produit 1");
        $produit->setSellPrice(13);
        $produit->setGamme($this->getReference('gamme1'));
        $produit->addFourniture($this->getReference('f1'),3);
        $produit->addFourniture($this->getReference('f2'),5);
        $manager->persist($produit);
        $this->setReference('p1',$produit);

        $produit = new Produit();
        $produit->setName("Produit 2");
        $produit->setSellPrice(14);
        $produit->setGamme($this->getReference('gamme1'));
        $produit->addFourniture($this->getReference('f1'),4);
        $produit->addFourniture($this->getReference('f2'),5);
        $manager->persist($produit);
        $this->setReference('p2',$produit);

        $produit = new Produit();
        $produit->setName("Produit 3");
        $produit->setSellPrice(39);
        $produit->setGamme($this->getReference('gamme1'));
        $produit->addFourniture($this->getReference('f1'),6);
        $produit->addFourniture($this->getReference('f2'),17);
        $manager->persist($produit);
        $this->setReference('p3',$produit);

        $produit = new Produit();
        $produit->setName("Produit b1");
        $produit->setSellPrice(50);
        $produit->setGamme($this->getReference('gamme2'));
        $produit->addFourniture($this->getReference('f3'),3);
        $produit->addFourniture($this->getReference('f4'),4);
        $produit->addFourniture($this->getReference('f5'),5);
        $manager->persist($produit);
        $this->setReference('pb1',$produit);

        $produit = new Produit();
        $produit->setName("Produit b2");
        $produit->setSellPrice(53);
        $produit->setGamme($this->getReference('gamme2'));
        $produit->addFourniture($this->getReference('f3'),5);
        $produit->addFourniture($this->getReference('f4'),2);
        $produit->addFourniture($this->getReference('f5'),11);
        $manager->persist($produit);
        $this->setReference('pb2',$produit);

        $produit = new Produit();
        $produit->setName("Produit b3");
        $produit->setSellPrice(34);
        $produit->setGamme($this->getReference('gamme2'));
        $produit->addFourniture($this->getReference('f3'),1);
        $produit->addFourniture($this->getReference('f4'),3);
        $manager->persist($produit);
        $this->setReference('pb3',$produit);



        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            FournitureFixture::class
            ];
    }
}