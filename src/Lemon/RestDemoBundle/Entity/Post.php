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
     * @Serializer\Accessor(getter="getCommentIds", setter="setCommentsFromIds")
     * @Serializer\Type("array")
     */
    protected $comments;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\Lemon\RestDemoBundle\Entity\Tag[]
     * @ORM\ManyToMany(targetEntity="Lemon\RestDemoBundle\Entity\Tag", cascade={"all"})
     * @ORM\JoinTable(name="Post_Tag",
     *     joinColumns={
     *          @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="tag_id", referencedColumnName="id", unique=true)
     *     }
     * )
     * @Serializer\Accessor(getter="getTagIds", setter="setTagsFromIds")
     * @Serializer\Type("array")
     **/
    protected $tags;

    public function getTagIds()
    {
        $tagIds = array();

        foreach ($this->tags as $tag) {
            $tagIds[] = $tag->getId();
        }

        return $tagIds;
    }

    public function setTagsFromIds($tagIds)
    {
        if (is_null($this->tags)) {
            $this->tags = new ArrayCollection;
        }
        foreach ($tagIds as $tagId) {
            $tag = new Tag;
            $tag->setId($tagId);
            $this->tags->add($tagId);
        }
    }

    public function getCommentIds()
    {
        $commentIds = array();

        foreach ($this->comments as $comment) {
            $commentIds[] = $comment->getId();
        }

        return $commentIds;
    }

    public function setCommentsFromIds($commentIds)
    {
        if (is_null($this->comments)) {
            $this->comments = new ArrayCollection;
        }
        foreach ($commentIds as $commentId) {
            $comment = new Comment;
            $comment->setId($commentId);
            $this->comments->add($comment);
        }
    }
}
