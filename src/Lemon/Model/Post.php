<?php
namespace Lemon\Model;

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
     * @var \Doctrine\Common\Collections\ArrayCollection|\Lemon\Model\Comment[]
     * @ORM\OneToMany(
     *  targetEntity="Lemon\Model\Comment",
     *  mappedBy="post",
     *  cascade={"all"}
     * )
     */
    protected $comments;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Lemon\Model\Tag[]
     * @ORM\ManyToMany(targetEntity="Lemon\Model\Tag", cascade={"all"})
     * @ORM\JoinTable(name="Post_Tag",
     *     joinColumns={
     *          @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *     }
     * )
     * @Serializer\Type("Lemon\RestBundle\Serializer\IdCollection<Lemon\Model\Tag>")
     **/
    protected $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }
}
