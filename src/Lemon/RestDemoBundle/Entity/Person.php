<?php
namespace Lemon\RestDemoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Lemon\RestBundle\Annotation as Rest;

/**
 * @ORM\Table()
 * @ORM\Entity()
 * @Rest\Resource()
 */
class Person
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var \Lemon\RestDemoBundle\Entity\Person
     * @ORM\OneToOne(targetEntity="Lemon\RestDemoBundle\Entity\Person", cascade={"all"})
     */
    protected $mother;

    /**
     * @var \Lemon\RestDemoBundle\Entity\Person
     * @ORM\OneToOne(targetEntity="Lemon\RestDemoBundle\Entity\Person", cascade={"all"})
     */
    protected $father;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Lemon\RestDemoBundle\Entity\Car[]
     * @ORM\OneToMany(
     *  targetEntity="Lemon\RestDemoBundle\Entity\Car",
     *  mappedBy="person",
     *  cascade={"all"}
     * )
     */
    protected $cars;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getMother()
    {
        return $this->mother;
    }

    public function setMother(Person $mother)
    {
        $this->mother = $mother;
    }

    public function getFather()
    {
        return $this->father;
    }

    public function setFather(Person $father)
    {
        $this->father = $father;
    }

    public function getCars()
    {
        return $this->cars;
    }

    public function setCars(ArrayCollection $cars)
    {
        $this->cars = $cars;
    }
}
