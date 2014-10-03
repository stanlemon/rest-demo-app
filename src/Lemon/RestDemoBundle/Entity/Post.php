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
class Post
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * @ORM\Column(name="body", type="text")
     */
    protected $body;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Lemon\RestDemoBundle\Entity\Comment[]
     * @ORM\OneToMany(
     *  targetEntity="Lemon\RestDemoBundle\Entity\Comment",
     *  mappedBy="post",
     *  cascade={"all"}
     * )
     */
    protected $comments;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Lemon\RestDemoBundle\Entity\Tag[]
     * @ORM\OneToMany(
     *  targetEntity="Lemon\RestDemoBundle\Entity\Tag",
     *  mappedBy="post",
     *  cascade={"all"}
     * )
     */
    protected $tags;
}
