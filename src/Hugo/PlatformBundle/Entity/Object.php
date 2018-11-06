<?php

namespace Hugo\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Object
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Hugo\PlatformBundle\Entity\ObjectRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Object
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Hugo\PlatformBundle\Entity\Category", cascade={"persist"})
     */
    private $categories;
    
    /**
     * @ORM\OneToOne(targetEntity="Hugo\PlatformBundle\Entity\Imageobj", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $imageobj;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add category
     *
     * @param \Hugo\PlatformBundle\Entity\Category $category
     *
     * @return Object
     */
    public function addCategory(\Hugo\PlatformBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Hugo\PlatformBundle\Entity\Category $category
     */
    public function removeCategory(\Hugo\PlatformBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set imageobj
     *
     * @param \Hugo\PlatformBundle\Entity\Imageobj $imageobj
     *
     * @return Object
     */
    public function setImageobj(\Hugo\PlatformBundle\Entity\Imageobj $imageobj = null)
    {
        $this->imageobj = $imageobj;

        return $this;
    }

    /**
     * Get imageobj
     *
     * @return \Hugo\PlatformBundle\Entity\Imageobj
     */
    public function getImageobj()
    {
        return $this->imageobj;
    }
}
