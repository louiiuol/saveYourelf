<?php

namespace Hugo\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hugo\PlatformBundle\Entity\Difficulty;

class LoadDifficulty implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $names = array(
      'Easy',
      'Medium',
      'Hard',
      'Expert'
    );

    foreach ($names as $name) {
      // On crée la catégorie
      $difficulty = new Difficulty();
      $difficulty->setName($name);

      // On la persiste
      $manager->persist($difficulty);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}