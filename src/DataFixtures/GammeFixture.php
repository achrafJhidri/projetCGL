<?php


namespace App\DataFixtures;


use App\Entity\Gamme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GammeFixture extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $gamme = new Gamme();
        $gamme->setName("Ficelles et bouts de cartons");
        $manager->persist($gamme);
        $this->setReference('gamme1',$gamme);


        $gamme = new Gamme();
        $gamme->setName("Emballages");
        $manager->persist($gamme);
        $this->setReference('gamme2',$gamme);

        $manager->flush();
    }
}