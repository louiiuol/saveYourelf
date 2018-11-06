<?php


namespace Hugo\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Hugo\PlatformBundle\Validator\Antiflood;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Hugo\PlatformBundle\Entity\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
  * @UniqueEntity(fields="title", message="Une annonce existe déjà avec ce titre.")
 */
class Advert
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="date", type="datetime")
   * @Assert\DateTime()
   */
  private $date;

  /**
   * @ORM\Column(name="title", type="string", length=255, unique=true)
   * @Assert\Length(min=3)
   */
  private $title;

  /**
   * @ORM\Column(name="author", type="string", length=255)
   * @Assert\Length(min=3)
   */
  private $author;

  /**
   * @ORM\Column(name="content", type="text")
   * @Assert\NotBlank()
   */
  private $content;

  /**
   * @ORM\OneToOne(targetEntity="Hugo\PlatformBundle\Entity\Image", cascade={"persist", "remove"})
   * @Assert\Valid()
   */
  private $image;

  /**
   * @ORM\ManyToMany(targetEntity="Hugo\PlatformBundle\Entity\Category", cascade={"persist"})
   */
  private $categories;

  /**
   * @ORM\ManyToMany(targetEntity="Hugo\PlatformBundle\Entity\Climate", cascade={"persist"})
   */
  private $climates;

  /**
   * @ORM\ManyToMany(targetEntity="Hugo\PlatformBundle\Entity\Object")
   */
  private $objects;

  /**
   * @ORM\ManyToMany(targetEntity="Hugo\PlatformBundle\Entity\Difficulty", cascade={"persist"})
   */
  private $difficulties;

  /**
   * @ORM\OneToMany(targetEntity="Hugo\PlatformBundle\Entity\Step", mappedBy="advert", cascade={"persist", "remove"})
   */
  private $steps;

  /**
   * @Gedmo\Slug(fields={"title"})
   * @ORM\Column(length=128, unique=true)
   */
  private $slug;



  /**
   * @ORM\Column(name="published", type="boolean")
   */
  private $published = true;
  /**
   * @ORM\OneToMany(targetEntity="Hugo\PlatformBundle\Entity\Application", mappedBy="advert")
   */
  private $applications; // Notez le « s », une annonce est liée à plusieurs candidatures

  /**
   * @ORM\Column(name="updated_at", type="datetime", nullable=true)
   */
  private $updatedAt;

  /**
   * @ORM\Column(name="nb_applications", type="integer")
   */
  private $nbApplications = 0;



  public function __construct()
  {
    $this->date         = new \Datetime();
    $this->categories   = new ArrayCollection();
    $this->difficulties   = new ArrayCollection();
    $this->applications = new ArrayCollection();
    $this->steps = new ArrayCollection();
  }

  /**
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param \DateTime $date
   * @return Advert
   */
  public function setDate($date)
  {
    $this->date = $date;
    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getDate()
  {
    return $this->date;
  }

  /**
   * @param string $title
   * @return Advert
   */
  public function setTitle($title)
  {
    $this->title = $title;
    return $this;
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * @param string $author
   * @return Advert
   */
  public function setAuthor($author)
  {
    $this->author = $author;
    return $this;
  }

  /**
   * @return string
   */
  public function getAuthor()
  {
    return $this->author;
  }

  /**
   * @param string $content
   * @return Advert
   */
  public function setContent($content)
  {
    $this->content = $content;
    return $this;
  }

  /**
   * @return string
   */
  public function getContent()
  {
    return $this->content;
  }

  /**
   * @param boolean $published
   * @return Advert
   */
  public function setPublished($published)
  {
    $this->published = $published;
    return $this;
  }

  /**
   * @return boolean
   */
  public function getPublished()
  {
    return $this->published;
  }

  /**
   * @param Image $image
   * @return Advert
   */
  public function setImage(Image $image = null)
  {
    $this->image = $image;
    return $this;
  }

  /**
   * @return Image
   */
  public function getImage()
  {
    return $this->image;
  }

  public function addCategory(Category $category)
  {
    $this->categories[] = $category;
    return $this;
  }

  public function removeCategory(Category $category)
  {
    $this->categories->removeElement($category);
  }

  public function getCategories()
  {
    return $this->categories;
  }

  /**
   * @param Application $application
   * @return Advert
   */
  public function addApplication(Application $application)
  {
    $this->applications[] = $application;

    // On lie l'annonce à la candidature
    $application->setAdvert($this);

    return $this;
  }

  /**
   * @param Application $application
   */
  public function removeApplication(Application $application)
  {
    $this->applications->removeElement($application);

    // Et si notre relation était facultative (nullable=true, ce qui n'est pas notre cas ici attention) :
    // $application->setAdvert(null);
  }

  /**
   * @return ArrayCollection
   */
  public function getApplications()
  {
    return $this->applications;
  }

  /**
   * @ORM\PreUpdate
   */
  public function updateDate()
  {
    $this->setUpdatedAt(new \Datetime());
  }

  public function setUpdatedAt(\Datetime $updatedAt)
  {
    $this->updatedAt = $updatedAt;
    return $this;
  }

  public function getUpdatedAt()
  {
    return $this->updatedAt;
  }

  public function increaseApplication()
  {
    $this->nbApplications++;
  }

  public function decreaseApplication()
  {
    $this->nbApplications--;
  }

    /**
     * Set nbApplications
     *
     * @param integer $nbApplications
     *
     * @return Advert
     */
    public function setNbApplications($nbApplications)
    {
        $this->nbApplications = $nbApplications;

        return $this;
    }

    /**
     * Get nbApplications
     *
     * @return integer
     */
    public function getNbApplications()
    {
        return $this->nbApplications;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Advert
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }



    /**
     * Add step
     *
     * @param \Hugo\PlatformBundle\Entity\Step $step
     *
     * @return Advert
     */
    public function addStep(\Hugo\PlatformBundle\Entity\Step $step)
    {
        $this->steps[] = $step;
        $step->setAdvert($this);

        return $this;
    }

    /**
     * Remove step
     *
     * @param \Hugo\PlatformBundle\Entity\Step $step
     */
    public function removeStep(\Hugo\PlatformBundle\Entity\Step $step)
    {
        $this->steps->removeElement($step);
    }

    /**
     * Get steps
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSteps()
    {
        return $this->steps;
    }


    /**
     * Add difficulty
     *
     * @param \Hugo\PlatformBundle\Entity\Difficulty $difficulty
     *
     * @return Advert
     */
    public function addDifficulty(\Hugo\PlatformBundle\Entity\Difficulty $difficulty)
    {
        $this->difficulties[] = $difficulty;

        return $this;
    }

    /**
     * Remove difficulty
     *
     * @param \Hugo\PlatformBundle\Entity\Difficulty $difficulty
     */
    public function removeDifficulty(\Hugo\PlatformBundle\Entity\Difficulty $difficulty)
    {
        $this->difficulties->removeElement($difficulty);
    }

    /**
     * Get difficulties
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDifficulties()
    {
        return $this->difficulties;
    }

    /**
     * Add climate
     *
     * @param \Hugo\PlatformBundle\Entity\Climate $climate
     *
     * @return Advert
     */
    public function addClimate(\Hugo\PlatformBundle\Entity\Climate $climate)
    {
        $this->climates[] = $climate;

        return $this;
    }

    /**
     * Remove climate
     *
     * @param \Hugo\PlatformBundle\Entity\Climate $climate
     */
    public function removeClimate(\Hugo\PlatformBundle\Entity\Climate $climate)
    {
        $this->climates->removeElement($climate);
    }

    /**
     * Get climates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClimates()
    {
        return $this->climates;
    }

    /**
     * Add object
     *
     * @param \Hugo\PlatformBundle\Entity\Object $object
     *
     * @return Advert
     */
    public function addObject(\Hugo\PlatformBundle\Entity\Object $object)
    {
        $this->objects[] = $object;

        return $this;
    }

    /**
     * Remove object
     *
     * @param \Hugo\PlatformBundle\Entity\Object $object
     */
    public function removeObject(\Hugo\PlatformBundle\Entity\Object $object)
    {
        $this->objects->removeElement($object);
    }

    /**
     * Get objects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjects()
    {
        return $this->objects;
    }
}
