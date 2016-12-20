<?php

namespace InstitutionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use InstitutionBundle\Model\UID;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Institution
 *
 * @ORM\Table(name="institution_category")
 * @ORM\Entity(repositoryClass="InstitutionBundle\Repository\CategoryRepository")
 */
class Category
{

    use ORMBehaviors\Sluggable\Sluggable;

    /**
     * @var int
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
     * @Assert\Length(
     *      min = "5",
     *      max = "200"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\Length(
     *      min = "50",
     *      max = "1000"
     * )
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="InstitutionBundle\Entity\Institution", mappedBy="category")
     */
    private $intitutions;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getIntitutions()
    {
        return $this->intitutions;
    }

    /**
     * @param mixed $intitutions
     */
    public function setIntitutions($intitutions)
    {
        $this->intitutions = $intitutions;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSluggableFields()
    {
        return [ 'name' ];
    }
}

