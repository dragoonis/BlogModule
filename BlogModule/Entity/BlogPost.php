<?php

namespace BlogModule\Entity;

class BlogPost
{

    protected $id;
    protected $published;
    protected $title;
    protected $content;
    protected $slug;
    protected $avatar;
    protected $created_at;
    protected $modified_at;

    protected $tags = array();
    protected $cats = array();

    public function __construct($data = array())
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    public function setCats($cats)
    {
        $this->cats = $cats;
    }

    public function getCats()
    {
        return $this->cats;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function getDay()
    {
        return date('d', strtotime($this->getCreatedAt()));
    }

    public function getMonth()
    {
        return date('M', strtotime($this->getCreatedAt()));
    }

    public function getYear()
    {
        return date('Y', strtotime($this->getCreatedAt()));
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getExcerpt($length = 60)
    {
        return strip_tags(substr($this->getContent(), 0, $length)) . "...";
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setModifiedAt($modified_at)
    {
        $this->modified_at = $modified_at;
    }

    public function getModifiedAt()
    {
        return $this->modified_at;
    }

    public function setPublished($published)
    {
        $this->published = $published;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getCatsAsPlainText()
    {
        $cats   = $this->getCats();
        $return = array();
        foreach ($cats as $cat)
        {
            $return[] = $cat->getTitle();
        }

        return implode(" ", $return);
    }

    public function getTagsAsPlainText()
    {
        $cats   = $this->getTags();
        $return = array();
        foreach ($cats as $cat)
        {
            $return[] = $cat->getTitle();
        }

        return implode(" ", $return);

    }

}
