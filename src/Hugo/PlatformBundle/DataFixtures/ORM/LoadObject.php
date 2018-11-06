<?php
/*

namespace Hugo\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hugo\PlatformBundle\Entity\Object;

class LoadObject implements FixtureInterface
{
 public function load(ObjectManager $manager)
  {
    //Materiaux
    $names = array(
    'rock',
    'slate',
    'wood',
    'ground',
    'cob',
    'tile', 
    'leather',
    'sand',
    'fabrix',
    'chalk',
    'sheet metal',
    'copper',
    'cotton',
    'sheep’s wool', 
    'hairs',
    'straw',
    'nails',
    'fiberglass',
    'heather',
    'hemp',
    'pine cone', 
    'moss',
    'water',
    'porcelain',
    'steel',
    'aluminium',
    'plastic',
    'tiles',
    'plaster',
    'PVC',
    'lime',
    'brick',
    'zinc',
    'paper',
    'rockwool',
    'polystyrene',
    'cardboard',
    'solid plastic',
    'flexible plastique' ,
    'rubber',
    'glass',
    'perpend',
    'blister wrap',
//HYGIENE = HEALTH  
    'soap',
    'tooth brush',
    'toothpaste',
    'shampooing',
    'hair bruch',
    'clothes pin',
    'towel',
    'cotton bud',
    'deodorant',
    'nail clipper',
    'nail polish',
    'nail pile',
    'scraper',
    'glove',
    'sanitory towel',
    'tampon',
    'dental floss',
//FUN
    'ball',
    'playing card',
    'book',
    'die',
    'doll',
    'tokens',
    'wooden toy',
    'plastic toy',
//SURVIE
    'rope',
    'bandages',
    'match',
    'water bottle',
    'pen',
    'bucket',
    'glass',
    'candle',
    'wax',
    'razor',
    'shower curtain',
    'mirror',
    'magnifying glass',
    'filter coffee',
    'keys',
    'tarp',
    'cover',
    'cutter',
//JARDINAGE
    'shovel',
    'rake',
    'spade',
    'watering can',
    'clippers',
    'wheelbarrow',
    'ladder',
    'chainsaw',
    'picket',
//PLANTES,
    'eucalyptus',
    'ginger',
    'mint',
    'poppy',
    'orthie',
    'dandelion',
    'sunflower',
    'colza',
    'sugar beet',
//TECHNOLOGIE
    'flashlight', 
    'TV',
    'charger',
    'battery',
    'cellphone',
    'light bulb',
    'console',
    'PC',
    'watch',
//PRATIQUE
    'lamp',
    'cellphone',
    'light bulb',
    'scissors',
    'pen',
    'pencil',
    'hammer' ,
    'knife',
    'fork',
    'bottle water',
    'bomb',
    'bag',
    'table',
    'clothes pin' ,
    'spoon',
    'spring',
    'newspaper',
    'condom',
    'tissue',
//VOYAGE
    'backpack',
    'pillowcase',
    'sleeping bag',
    'mosquito net',
    'sunglasses',
    'fan',
    'suitcase',
    'vanity',
    'hairdyer',
    'sheets',
    'child buoy',
    'sunscreen',
    'hat',
    'sail'
    );


    foreach ($names as $name) {
      // On crée la compétence
      $object = new Object();
      $object->setName($name);

      // On la persiste
      $manager->persist($object);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}