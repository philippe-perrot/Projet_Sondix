<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PersonneFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $personne = new Personne();
        $personne->setLogin('root');
        $personne->setMdp($this->encoder->encodePassword($personne, 'root'));
        $personne->setIdRole('4');
        $personne->setNom('root');
        $personne->setPrenom('root');
        $manager->persist($personne);
        $manager->flush();
    }
}
