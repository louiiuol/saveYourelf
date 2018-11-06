<?php

namespace Hugo\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hugo\PlatformBundle\Entity\Climate;

class LoadClimate implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $names = array(
      'Any climate',
      'Tropical',
      'Dry',
      'Moutain',
      'Equatorial',
      'Oceanic',
      'Continental',
      'Polar'
    );

    foreach ($names as $name) {
      // On crée la catégorie
      $climate = new Climate();
      $climate->setName($name);

      // On la persiste
      $manager->persist($climate);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}