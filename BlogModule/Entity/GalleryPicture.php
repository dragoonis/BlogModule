<?php

namespace BlogModule\Entity;

class GalleryPicture
{

    protected $id;
    protected $album_id;
    protected $file_name;
    protected $status;
    protected $created_at;
    protected $modified_at;

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

    public function setAlbumId($album_id)
    {
        $this->album_id = $album_id;
    }

    public function getAlbumId()
    {
        return $this->album_id;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setFileName($file_name)
    {
        $this->file_name = $file_name;
    }

    public function getFileName()
    {
        return $this->file_name;
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

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

}