<?php

namespace BlogAdminModule\Classes;

class BlogPostHelper
{

    protected $tagsStorage;
    protected $catsStorage;
    protected $postStorage;
    protected $postTagStorage;
    protected $postCatStorage;

    public function savePost($post)
    {

        return $this->postStorage->update($post, array('id' => $post['id']));
    }

    public function saveTags($tags, $postId)
    {

        if (empty($tags)) {
            return false;
        }

        $tags = explode(',', $tags);

        foreach ($tags as $tag) {

            $tagId = $this->tagsStorage->getIdByTitle($tag);

            if (!$tagId) {
                $tagId = $this->tagsStorage->create(
                    array(
                        'title'       => $tag,
                        'slug'        => $this->slug($tag),
                        'created_at'  => date('Y-m-d H:i:s'),
                        'modified_at' => date('Y-m-d H:i:s')
                    )
                );
            }

            if (!$this->postTagStorage->isExists($tagId, $postId)) {
                $this->postTagStorage->create(
                    array(
                        'post_id' => $postId,
                        'tag_id'  => $tagId
                    )
                );
            }

        }

        return true;
    }

    public function saveCategories($categories, $postId)
    {

        if (empty($categories)) {
            return false;
        }

        foreach ($categories as $cat) {

            if (!$this->postCatStorage->isExists($cat, $postId)) {
                $this->postCatStorage->create(
                    array(
                         'post_id'      => $postId,
                         'category_id'  => $cat
                    )
                );
            }
        }

        return true;
    }

    public function getPost($id)
    {
        return $this->postStorage->getById($id);
    }

    public function getPostBySlug($slug)
    {
        return $this->postStorage->getBySlug($slug);
    }

    public function getPostTags($postId)
    {

        $tags = array();
        $rows = $this->postTagStorage->getByPostId($postId);

        foreach($rows as $row) {
            $tags[] = $row->getTitle();
        }

        return implode(',', $tags);
    }

    public function getPostCats($postId)
    {
        $categories = array();
        $rows       = $this->postCatStorage->getByPostId($postId);

        foreach ($rows as $row) {
            $categories[] = $row->getTitle();
        }

        return $categories;
    }

    // Setters/Getters

    public function setPostCatStorage($postCatStorage)
    {
        $this->postCatStorage = $postCatStorage;
    }

    public function getPostCatStorage()
    {
        return $this->postCatStorage;
    }

    public function setPostTagStorage($postTagStorage)
    {
        $this->postTagStorage = $postTagStorage;
    }

    public function getPostTagStorage()
    {
        return $this->postTagStorage;
    }

    public function setCatsStorage($catsStorage)
    {
        $this->catsStorage = $catsStorage;
    }

    public function getCatsStorage()
    {
        return $this->catsStorage;
    }

    public function setPostStorage($postStorage)
    {
        $this->postStorage = $postStorage;
    }

    public function getPostStorage()
    {
        return $this->postStorage;
    }

    public function setTagsStorage($tagsStorage)
    {
        $this->tagsStorage = $tagsStorage;
    }

    public function getTagsStorage()
    {
        return $this->tagsStorage;
    }

    function slug($string)
    {
        $str = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return strtolower($str);
    }

}