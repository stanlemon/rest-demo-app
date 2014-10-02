<?php
namespace Lemon\RestDemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lemon\RestBundle\Annotation as Rest;
use Lemon\RestBundle\Tests\Fixtures\Person;

/**
 * @ORM\Table()
 * @ORM\Entity()
 * @Rest\Resource()
 */
class Car
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(name="year", type="string", length=255, nullable=false)
     */
    protected $year;

    /**
     * @ORM\ManyToOne(targetEntity="Lemon\RestDemoBundle\Entity\Person", inversedBy="cars")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    protected $person;

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

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getPerson()
    {
        return $this->person;
    }

    public function setPerson(Person $person)
    {
        $this->person = $person;
    }
}
