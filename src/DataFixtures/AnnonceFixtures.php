<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\DataFixtures\AnnonceFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AnnonceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1;$i <= 10; $i++){
            $annonce = new Annonce();
            $annonce->setTitle("Titre de l'article n°$i")
                    ->setContent("<p>Contenu de l'annonce n°$i</p>")
                    ->setImage("http://placehold.it/350x150")
                    ->setcreatedAt(new \DateTime());

                    $manager->persist($annonce);
        }
        $manager->flush();
    }
}
