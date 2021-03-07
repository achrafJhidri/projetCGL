<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = (new User())
        ->setUsername("admin")
        ->setRoles(["ROLE_USER","ROLE_ADMIN"]);
        $password = $this->encoder->encodePassword($user, 'admin');
        $user->setPassword($password);

        $manager->persist($user);


        $user1 = (new User())
            ->setUsername("user");
        $password = $this->encoder->encodePassword($user, 'user');
        $user1->setPassword($password);

        $manager->persist($user1);

        $manager->flush();
    }
}
