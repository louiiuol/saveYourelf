<?php

namespace Hugo\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AdvertRepository extends EntityRepository
{
  public function getAdverts($page,$nbPerPage)
  {
    $query = $this->createQueryBuilder('a')
      // Jointure sur l'attribut image
      ->leftJoin('a.image', 'i')
      ->addSelect('i')
      // Jointure sur l'attribut categories
      ->leftJoin('a.categories', 'c')
      ->addSelect('c')
      ->orderBy('a.date', 'DESC')
      ->getQuery()  
    ;

    $query
      // On définit l'annonce à partir de laquelle commencer la liste
      ->setFirstResult(($page-1) * $nbPerPage)
      // Ainsi que le nombre d'annonce à afficher sur une page
      ->setMaxResults($nbPerPage)
    ;

    // Enfin, on retourne l'objet Paginator correspondant à la requête construite
    // (n'oubliez pas le use correspondant en début de fichier)
    return new Paginator($query, true);
  }

    public function getAdvertsWithAdmin()
  {
    $qb = $this->createQueryBuilder('a')
      // Jointure sur l'attribut image
      ->leftJoin('a.image', 'i')
      ->addSelect('i')
      // Jointure sur l'attribut categories
      ->leftJoin('a.categories', 'c')
      ->addSelect('c')
      ->orderBy('a.date', 'DESC')
    ;

    return $qb
      ->getQuery()
      ->getResult()
    ;

  }
    public function getAdvertsWithCategories(array $categoryNames)
  {
    $qb = $this->createQueryBuilder('a');

      // Jointure sur l'attribut image
      $qb
      ->leftJoin('a.image', 'i')
      ->addSelect('i')
      // Jointure sur l'attribut categories
      ->leftJoin('a.categories', 'c')
      ->addSelect('c')
      ->orderBy('a.date', 'DESC')
      ->where($qb->expr()->in('c.name', $categoryNames))
    ;

    return $qb
      ->getQuery()
      ->getResult()
    ;
  }

  public function getSaviesWithFilters($categoryNames, $difficultyNames, $climateNames, $objectNames)
  {
    $qb = $this->createQueryBuilder('a');


    $qb
      ->join('a.categories', 'c')
      ->addSelect('c')
      ->join('a.difficulties', 'd')
      ->addSelect('d')
      ->join('a.climates', 'clim')
      ->addSelect('clim')
      ->join('a.objects', 'o')
      ->addSelect('o')
      ->where($qb->expr()->in('c.id', $categoryNames));
      $qb->andWhere($qb->expr()->in('d.id', $difficultyNames));
      $qb->andWhere($qb->expr()->in('clim.id', $climateNames));
      $qb->andWhere($qb->expr()->in('o.id', $objectNames));

    return $qb
      ->getQuery()
      ->getResult()
    ;
  }



}