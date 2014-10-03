<?php
namespace Lemon\RestDemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use Lemon\RestBundle\Annotation as Rest;

/**
 * @ORM\Table()
 * @ORM\Entity()
 * @Rest\Resource()
 */
class Comment
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="body", type="text")
     */
    protected $body;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $created_at;

    /**
     * @ORM\Column(name="post_id", type="integer", nullable=false)
     */
    protected $post_id;

    /**
     * @ORM\ManyToOne(targetEntity="Lemon\RestDemoBundle\Entity\Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;
}
