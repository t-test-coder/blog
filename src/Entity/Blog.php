<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog")
 * @ORM\HasLifecycleCallbacks
 */
class Blog
{
    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
       $this->setUpdated(new \DateTime());
    }  
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $author;

    /**
     * @ORM\Column(type="text")
     */
    protected $blog;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $image;

    /**
     * @ORM\Column(type="text")
     */
    protected $tags;

    protected $comments = array();

    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    public function setTitle($title) {
      $this->title = $title;
    }

    public function setBlog($blog) {
      $this->blog = $blog;
    }

    public function setImage($image) {
      $this->image = $image;
    }

    public function setAuthor($author) {
      $this->author = $author;
    }

    public function setTags($tags) {
      $this->tags = $tags;
    }
    public function setCreated($created) {
      $this->created = $created;
    }

    public function setUpdated($updated) {
      $this->updated = $updated;
    }

    public function getTitle() {
      return $this->title;
    }

    public function getBlog() {
      return $this->blog;
    }

    public function getImage() {
      return $this->image;
    }

    public function getAuthor() {
      return $this->author;
    }

    public function getTags() {
    return  $this->tags ;
    }
    public function getCreated() {
      return $this->created;
    }

    public function getUpdated() {
    return $this->updated;
    }



}
?>
