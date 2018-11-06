<?php

namespace Hugo\PlatformBundle\Controller;

use Hugo\PlatformBundle\Entity\Advert;
use Hugo\PlatformBundle\Entity\Object;
use Hugo\UserBundle\Entity\User;
use Hugo\PlatformBundle\Form\AdvertType;
use Hugo\PlatformBundle\Form\AdvertEditType;
use Hugo\PlatformBundle\Form\ObjectType;
use Hugo\PlatformBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



class AdvertController extends Controller
{

    public function indexAction()
    {
      return $this->render('HugoPlatformBundle:Advert:index.html.twig');
    }

    public function faqAction()
    {
      return $this->render('HugoPlatformBundle:Advert:faq.html.twig');
    }


//SAVE ME

    public function savemeAction(Request $request)
    {
      $cat = $this->getDoctrine()->getRepository('HugoPlatformBundle:Category')->findAll();
      $dif = $this->getDoctrine()->getRepository('HugoPlatformBundle:Difficulty')->findAll();
      $clim = $this->getDoctrine()->getRepository('HugoPlatformBundle:Climate')->findAll();
      $obj = $this->getDoctrine()->getRepository('HugoPlatformBundle:Object')->findAll();



      $listSavies = null;

      if ($request->isMethod('post'))
      {
      $listSavies = $this->getDoctrine()
        ->getManager()
        ->getRepository('HugoPlatformBundle:Advert')
        ->getSaviesWithFilters($request->request->get('categoryNames'),
                               $request->request->get('difficultyNames'),
                               $request->request->get('climateNames'),
                               $request->request->get('objectNames')
                               );
      }
      return $this->render('HugoPlatformBundle:Advert:saveme.html.twig', array(
          'listSavies' => $listSavies, 
          'categories' => $cat, 
          'difficulties' => $dif,
          'climates' => $clim,
          'objects' => $obj
          ));
    }


// Page ALL SAVIES
    public function saviesAction($page)
    {

        $nbPerPage = 5;


        $listAdverts = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Advert')
          ->getAdverts($page, $nbPerPage)
        ;

        $nbPages = ceil(count($listAdverts)/$nbPerPage);


        return $this->render('HugoPlatformBundle:Advert:savies.html.twig', array(
          'listAdverts' => $listAdverts,
          'nbPages'     => $nbPages,
          'page'        => $page
        ));
    }

// Page modale : My savies
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function mysaviesAction()
    {

        $listAdverts = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Advert')
          ->getAdvertsWithAdmin()
        ;
        return $this->render('HugoPlatformBundle:Advert:mysavies.html.twig', array(
          'listAdverts' => $listAdverts
        ));
    }

    public function categoriesAction()
    {

        // On récupère notre objet Paginator

        $listAdvertsSurvival = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Advert')
          ->getAdvertsWithCategories(array('Survival'))
        ;
        $listAdvertsHandy = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Advert')
          ->getAdvertsWithCategories(array('Handy'))
        ;
        $listAdvertsDecorative = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Advert')
          ->getAdvertsWithCategories(array('Decorative'))
        ;
        $listAdvertsHealth = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Advert')
          ->getAdvertsWithCategories(array('Health'))
        ;
        $listAdvertsTechnology = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Advert')
          ->getAdvertsWithCategories(array('Technology'))
        ;
        $listAdvertsTravel = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Advert')
          ->getAdvertsWithCategories(array('Travel'))
        ;
        $listAdvertsGardening = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Advert')
          ->getAdvertsWithCategories(array('Gardening'))
        ;

        $listAdvertsMaterials = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Advert')
          ->getAdvertsWithCategories(array('Materials'))
        ;

        // On donne toutes les informations nécessaires à la vue
        return $this->render('HugoPlatformBundle:Advert:categories.html.twig', array(
          'listAdvertsSurvival' => $listAdvertsSurvival,
          'listAdvertsHandy' => $listAdvertsHandy,
          'listAdvertsDecorative' => $listAdvertsDecorative,
          'listAdvertsHealth' => $listAdvertsHealth,
          'listAdvertsTechnology' => $listAdvertsTechnology,
          'listAdvertsTravel' => $listAdvertsTravel,
          'listAdvertsGardening' => $listAdvertsGardening,
          'listAdvertsMaterials' => $listAdvertsMaterials,
        ));
    }
//VIEW
  public function viewAction(Advert $advert)
  {

      // Puis modifiez la ligne du render comme ceci, pour prendre en compte les variables :
      return $this->render('HugoPlatformBundle:Advert:view.html.twig', array(
        'advert'           => $advert
      ));
  }
    
  //ADD
    /**
    * @Security("has_role('ROLE_USER')")
    */
  public function addAction(Request $request)
  {

     $advert = new Advert();
       $advert->setAuthor($this->getUser());
       $form = $this->createForm(new AdvertType(), $advert);

        if ($form->handleRequest($request)->isValid()) {

          $em = $this->getDoctrine()->getManager();
          $em->persist($advert);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

          return $this->redirect($this->generateUrl('hugo_platform_view', array('slug' => $advert->getSlug())));
        }

        return $this->render('HugoPlatformBundle:Advert:add.html.twig', array(
          'form' => $form->createView(),
        ));
  }

//EDIT
    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function editAction(Advert $advert, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $form = $this->createForm(new AdvertEditType(), $advert);

    if ($form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre annonce
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirect($this->generateUrl('hugo_platform_view', array('slug' => $advert->getSlug())));
    }

    return $this->render('HugoPlatformBundle:Advert:edit.html.twig', array(
      'form'   => $form->createView(),
      'advert' => $advert // Je passe également l'annonce à la vue si jamais elle veut l'afficher
    ));
  }

//DELETE
    /**
    * @Security("has_role('ROLE_USER')")
    */
  public function deleteAction(Advert $advert, Request $request)
  {
    $em = $this->getDoctrine()->getManager();


    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->createFormBuilder()->getForm();

    if ($form->handleRequest($request)->isValid()) {
      $em->remove($advert);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");

      return $this->redirect($this->generateUrl('hugo_platform_home'));
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('HugoPlatformBundle:Advert:delete.html.twig', array(
      'advert' => $advert,
      'form'   => $form->createView()
    ));
  }

//MENU
  /*public function menuAction($limit = 3)
  {

    $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('HugoPlatformBundle:Advert')
      ->findBy(
        array(),                 // Pas de critère
        array('date' => 'desc'), // On trie par date décroissante
        $limit,                  // On sélectionne $limit annonces
        0                        // À partir du premier
    );

    return $this->render('HugoPlatformBundle:Advert:menu.html.twig', array(
      'listAdverts' => $listAdverts
    ));
  }*/

//ADMINISTRATION ET OBJETS
    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function adminAction(Request $request)
    {

       $object = new Object();
       $form = $this->createForm(new ObjectType(), $object);

        if ($form->handleRequest($request)->isValid()) {

          $em = $this->getDoctrine()->getManager();
          $em->persist($object);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Objet bien enregistrée.');

          return $this->redirect($this->generateUrl('hugo_platform_admin'));
        }
        $listAdverts = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Advert')
          ->getAdvertsWithAdmin()
        ;

        // On récupère notre objet Paginator

        $listObjectsSurvival = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Object')
          ->getObjectsWithCategories(array('Survival'))
        ;
        $listObjectsHandy = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Object')
          ->getObjectsWithCategories(array('Handy'))
        ;
        $listObjectsDecorative = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Object')
          ->getObjectsWithCategories(array('Decorative'))
        ;
        $listObjectsHealth = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Object')
          ->getObjectsWithCategories(array('Health'))
        ;
        $listObjectsTechnology = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Object')
          ->getObjectsWithCategories(array('Technology'))
        ;
        $listObjectsTravel = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Object')
          ->getObjectsWithCategories(array('Travel'))
        ;
        $listObjectsGardening = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Object')
          ->getObjectsWithCategories(array('Gardening'))
        ;
        $listObjectsMaterials = $this->getDoctrine()
          ->getManager()
          ->getRepository('HugoPlatformBundle:Object')
          ->getObjectsWithCategories(array('Materials'))
        ;


        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->render('HugoPlatformBundle:Advert:admin.html.twig', array(
          'listAdverts' => $listAdverts,
          'users'       => $users,
          'form' => $form->createView(),
          'listObjectsSurvival' => $listObjectsSurvival,
          'listObjectsHandy' => $listObjectsHandy,
          'listObjectsDecorative' => $listObjectsDecorative,
          'listObjectsHealth' => $listObjectsHealth,
          'listObjectsTechnology' => $listObjectsTechnology,
          'listObjectsTravel' => $listObjectsTravel,
          'listObjectsGardening' => $listObjectsGardening,
          'listObjectsMaterials' => $listObjectsMaterials
        ));
    }

    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
public function admineditAction(Object $object, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $form = $this->createForm(new ObjectType(), $object);

    if ($form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre annonce
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Object bien modifié.');

      return $this->redirect($this->generateUrl('hugo_platform_admin'));
    }

    return $this->render('HugoPlatformBundle:Advert:adminedit.html.twig', array(
      'form'   => $form->createView(),
      'object' => $object // Je passe également l'annonce à la vue si jamais elle veut l'afficher
    ));
  }

    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
  public function admindeleteAction(Object $object, Request $request)
  {
    $em = $this->getDoctrine()->getManager();


    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->createFormBuilder()->getForm();

    if ($form->handleRequest($request)->isValid()) {
      $em->remove($object);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'objet a bien été supprimé.");

      return $this->redirect($this->generateUrl('hugo_platform_admin'));
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('HugoPlatformBundle:Advert:admindelete.html.twig', array(
      'object' => $object,
      'form'   => $form->createView()
    ));
  }

}
