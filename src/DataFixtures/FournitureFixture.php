<?php


namespace App\DataFixtures;


use App\Entity\Fourniture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FournitureFixture extends Fixture  implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $fourniture = new Fourniture();
        $fourniture->setName("Bout de carton");
        $fourniture->setBuyPrice(1);
        $fourniture->setGamme($this->getReference('gamme1'));
        $fourniture->setIsPriceUpdatable(true);
        $manager->persist($fourniture);
        $this->setReference('f1',$fourniture);

        $fourniture = new Fourniture();
        $fourniture->setName("Ficelle");
        $fourniture->setBuyPrice(2);
        $fourniture->setGamme($this->getReference('gamme1'));
        $fourniture->setIsPriceUpdatable(false);
        $manager->persist($fourniture);
        $this->setReference('f2',$fourniture);


        $fourniture = new Fourniture();
        $fourniture->setName("Papier d'emballage");
        $fourniture->setBuyPrice(2);
        $fourniture->setGamme($this->getReference('gamme2'));
        $fourniture->setIsPriceUpdatable(true);
        $manager->persist($fourniture);
        $this->setReference('f3',$fourniture);

        $fourniture = new Fourniture();
        $fourniture->setName("Ruban");
        $fourniture->setBuyPrice(2);
        $fourniture->setGamme($this->getReference('gamme2'));
        $fourniture->setIsPriceUpdatable(false);
        $manager->persist($fourniture);
        $this->setReference('f4',$fourniture);

        $fourniture = new Fourniture();
        $fourniture->setName("Etiquette");
        $fourniture->setBuyPrice(3);
        $fourniture->setGamme($this->getReference('gamme2'));
        $fourniture->setIsPriceUpdatable(false);
        $manager->persist($fourniture);
        $this->setReference('f5',$fourniture);

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            GammeFixture::class,
        ];
    }
}